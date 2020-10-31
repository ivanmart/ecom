<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Catalog Controller
 */

class CatalogController extends Controller
{

    /**
     * Main catalog page method
     * @param  Request $request
     * @param  Product $product
     * @return View
     */
    public function index(Request $request, Product $product)
    {
        $query = $product->newQuery();

        /*
        |--------------------------------------------------------------------------
        | FILTERS
        |--------------------------------------------------------------------------
        */

        // TODO: !!! bring into compliance with DRY principle

        // price
        if ($request->has('price')) {
            list($from, $to) = explode("-", array_keys($request->input('price'))[0]);
            $cond = [];
            if ($from) {
                $cond[] = ['price', '>=', $from];
            }
            if ($to) {
                $cond[] = ['price', '<=', $to];
            }
            $query->where($cond);
        }

        // square
        if ($request->has('square')) {
            $query->whereHas('light', function ($query) use ($request) {
                list($from, $to) = explode("-", array_keys($request->input('square'))[0]);
                $cond = [];
                if ($from) {
                    $cond[] = ['square', '>=', $from];
                }
                if ($to) {
                    $cond[] = ['square', '<=', $to];
                }
                $query->where($cond);
                return $query;
            });
        }

        // height
        if ($request->has('height')) {
            $query->whereHas('light', function ($query) use ($request) {
                list($from, $to) = explode("-", array_keys($request->input('height'))[0]);
                $cond = [];
                if ($from) {
                    $cond[] = ['height', '>=', $from];
                }
                if ($to) {
                    $cond[] = ['height', '<=', $to];
                }
                $query->where($cond);
                return $query;
            });
        }

        // style
        if ($request->has('style')) {
            $query->whereHas('light', function ($query) use ($request) {
                $i = 0;
                foreach ($request->input('style') as $f => $tmp) {
                    $where = ($i++ ? 'orWhere' : 'where');
                    $query->$where('style_id', $f);
                }
                return $query;
            });
        }

        // collection
        if ($request->has('collection')) {
            $query->whereHas('light', function ($query) use ($request) {
                $i = 0;
                foreach ($request->input('collection') as $f => $tmp) {
                    $where = ($i++ ? 'orWhere' : 'where');
                    $query->$where('collection_id', $f);
                }
                return $query;
            });
        }

        // collection by slug
        if ($request->collection_slug) {
            $query->whereHas('light', function ($query) use ($request) {
                return $query->whereHas('collection', function ($query) use ($request) {
                    return $query->where('slug', $request->collection_slug);
                });
            });
        }

        // style by slug
        if ($request->style_slug) {
            $query->whereHas('light', function ($query) use ($request) {
                return $query->whereHas('style', function ($query) use ($request) {
                    return $query->where('slug', $request->style_slug);
                });
            });
        }

        // search
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%');
            $query->orWhereHas('light', function ($query) use ($request) {
                return $query->whereHas('collection', function ($query) use ($request) {
                    return $query->where('name', 'like', '%' . $request->input('search') . '%');
                });
            });
        }

        // getCount
        if ($request -> has('getCount')) {
            $count = $query->onlyCeiling()->with('categories', 'light.collection')->count();
            return response()->json(["count" => $count]);
        }

        // prepare url parameters for pagination
        $links = array_map(function () use ($request) {
            foreach ($request->except('page') as $filter) {
                foreach ($filter as $key => $val) {
                    $new[$key] = 1;
                }
            }
            return $new;
        }, $request->except('page'));

        // select items
        $items = $query->onlyCeiling()->with('categories', 'light.collection')->paginate(48);

        // ajax request (load more)
        if ($request -> ajax()) {
            return response()
                ->json(View::make('partials.products', [
                    'items' => $items,
                    'total' => $items->total(),
                    'template' => 'dark',
                    'links' => $links
                ])->render());
        }

        // return view
        // TODO: !!! use Laravel locaization
        return View::make('catalog', [
            'title' => 'Каталог',
            'bodyclass' => 'products',
            'items' => $items,
            'total' => $items->total(),
            'template' => 'dark',
            'partial' => 'products',
            'links' => $links
        ]);
    }

    /**
     * Search page method
     * @param  Request $request
     * @param  Product $product
     * @return View
     */
    public function search(Request $request, Product $product)
    {
        $query = $product->newQuery();

        // search by product or collection name
        $query->where('name', 'like', '%' . urldecode($request->input('search')) . '%');
        $query->orWhereHas('light', function ($query) use ($request) {
            return $query->whereHas('collection', function ($query) use ($request) {
                return $query->where('name', 'like', '%' . urldecode($request->input('search')) . '%');
            });
        });

        // eager load categories and collection
        $items = $query->with('categories', 'light.collection')->take(10)->get();

        return View::make('partials.search', [
            'items' => $items,
        ]);
    }


    /**
     * Product detailed view method
     * @param  Request $request
     * @param  String  $category
     * @param  String  $slug
     * @return [type]            [description]
     */
    public function detail(Request $request, $category, $slug)
    {
        $product = Product::where(['slug' => $slug])->with([
            'images', 'categories', 'brand', 'light', 'bulb'
        ])->firstOrFail();

        // Family products
        $fps = [];
        if ($fls = $product->light->family) {
            $fls = $product->light->family->lights()->has('product')->with('product')->get();
            foreach ($fls as $fl) {
                // skip same product and products from same category
                if (
                    $fl->product->id == $product->id ||
                    !empty(array_intersect(
                        $fl->product->categories->pluck('id')->toArray(),
                        $product->categories->pluck('id')->toArray()
                    ))
                ) {
                    continue;
                }
                $fps[] = $fl->product;
            }
        }

        // viewed recently
        $r_cookie = unserialize(\Cookie::get('recently'));

        if (!is_array($r_cookie)) {
            $r_cookie = [];
        }
        if (count($r_cookie)>15) {
            $r_cookie = array_slice($r_cookie, count($r_cookie) - 15);
        }
        $r_cookie = array_diff($r_cookie, [$product->id]);
        $recently = Product::findMany($r_cookie);

        // store viewed recently
        $r_cookie[] = $product->id;
        \Cookie::queue(\Cookie::make('recently', serialize($r_cookie), 43200));

        return View::make('detail', [
            'product' => $product,
            'family_products' => $fps,
            'recently' => $recently
        ]);
    }
}
