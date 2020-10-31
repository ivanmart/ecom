<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Collections Controller
 */

class CollectionController extends Controller
{

    /**
     * Collections index page
     * @param  Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // prepare variables for sorting
        \DB::update('set @x := 0, @y := -1;');

        $items = Collection::
            // alternate dark/light templates
            select(\DB::raw('CASE WHEN `template`=\'light\' THEN @x:=@x+2 ELSE @y:=@y+2 END z, collections.*'))->
            // has image
            whereNotNull('image')->
            // has more than one product
            whereHas('products', function ($q) {
                return $q->havingRaw('COUNT(*) > 1');
            })->
            // sort by alternate dark/light templates
            orderBy('z')->
            get();

        // ajax request (load more)
        if ($request -> ajax()) {
            return response()
                -> json(View::make('partials.large-list', array('items' => $items)) -> render());
        }

        // return view
        // TODO: !!! use Laravel locaization
        return View::make('catalog', array(
            'title' => 'Коллекции',
            'bodyclass' => 'collections',
            'items' => $items,
            'filter' => 'collection',
            'name_prefix' => 'Коллекция<br>',
            'partial' => 'large-list',
            'with_products' => true,
        ));
    }
}
