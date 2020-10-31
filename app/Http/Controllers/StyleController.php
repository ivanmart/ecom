<?php

namespace App\Http\Controllers;

use App\Models\Style;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Styles Controller
 */

class StyleController extends Controller
{

    /**
     * Index page for Styles
     * @param  Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // prepare variables for sorting
        \DB::update('set @x := 0, @y := -1;');

        $items = Style::
            // alternate dark/light templates
            select(\DB::raw('CASE WHEN `template`=\'light\' THEN @x:=@x+2 ELSE @y:=@y+2 END z, styles.*'))->
            // sort by alternate dark/light templates
            orderBy('z')->
            get();

        // a counter for grouping by two products per item
        \DB::update('set @num := 0');

        // select items
        $items = Style::whereHas('products')
            ->with(['products' => function($q){
                // group by nine products with info about collection and categories
                $q->select(\DB::raw('`products`.*, (@num := @num + 1) %9 as rank'))
                    ->groupBy('style_id', 'rank')
                    ->with(['light' => function($q){
                        $q->with('collection');
                      },
                      'categories'
                    ]);
                }])->paginate(5);

        // ajax request (load more)
        if ($request -> ajax()) {
            return response()
                -> json(View::make('partials.large-list', array('items' => $items)) -> render());
        }

        // return view
        return View::make('catalog', array(
            'title' => 'Стили',
            'bodyclass' => 'styles',
            'items' => $items,
            'filter' => 'style',
            'name_prefix' => '',
            'partial' => 'large-list',
            'with_products' => true,
        ));
    }
}
