<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;


/**
 * Products Controller
 */

class ParametersController extends Controller
{

    /**
     * Products
     *
     * @return void
     */

    public function index(Request $request)
    {
        $products = Product::paginate(26);
        if ($request->ajax())
        {
            return response()->json(View::make('partials.products', array('products' => $products))->render());
        }
        return View::make('catalog', array('products' => $products));
    }
}