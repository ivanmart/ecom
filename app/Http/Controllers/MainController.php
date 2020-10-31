<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Style;
use App\Models\Collection;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

/**
 * Main Controller
 */

class MainController extends Controller
{
    /**
     * Index page method
     * @param  Request $request
     * @return View
     */
    public function index(Request $request)
    {
        // Banners
        $banners = Banner::published()->orderBy('lft')->get();

        // Styles
        // prepare variables for sorting
        \DB::update('set @x := 0, @y := -1;');

        $styles = Style::
            // alternate dark/light templates
            select(\DB::raw('CASE WHEN `template`=\'light\' THEN @x:=@x+2 ELSE @y:=@y+2 END z, styles.*'))->
            // sort by alternate dark/light templates
            orderBy('z')->
            paginate(5);

        // Collections
        // prepare variables for sorting
        \DB::update('set @x := 0, @y := -1;');

        $collections = Collection::
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
            paginate(5);

        // return view
        return View::make('main', array(
            'banners' => $banners,
            'styles' => $styles,
            'collections' => $collections,
        ));
    }

    /**
     * Contact form send method
     * @param  Request $request
     * @return void
     */
    public function contact(Request $request)
    {
        \Mail::send('email.contact', [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'msg' => $request->input('msg'),
            ], function ($message) {
                $message->subject(Config::get('app.name') . ' feedback');
                $message->from(Config::get('app.contact_email'), Config::get('app.name'));
                $message->to(Config::get('app.contact_email'));
            });
    }
}
