<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\CartOrderPostRequest;
use Illuminate\Support\Facades\View;

use \App\Services\CityService;

use Lenius\Basket\Basket;
use Lenius\Basket\Storage\Session;
use Lenius\Basket\Identifier\Cookie;

use Illuminate\Support\Facades\Mail;

/**
 * Cart Controller
 */

class CartController extends Controller
{

    /**
     * Main basket variable
     * @var Basket
     */
    protected $basket;

    /**
     * Basket constructor
     */
    public function __construct()
    {
        $this->basket = new Basket(new Session, new Cookie);
    }

    /**
     * Add to basket method
     * @param Request $request
     */
    public function add(Request $request)
    {
        $sku = $request->input('sku');

        if ($item = Product::where(['name' => $sku])->first()) {
            $this->basket->insert([
                'id' => $item->id,
                'name' => $item->name,
                'price' => $item->price,
                'weight' => $item->weight,
                'quantity' => 1,
            ]);

            $total = $count = $cur_count = $cur_total = 0;
            foreach ($this->basket->contents() as $item) {
                if ($item->name == $sku) {
                    $cur_count = $item->quantity;
                    $cur_total = $item->price * $item->quantity;
                }
            }
            $count = $this->basket->totalItems();
            $total = number_format($this->basket->total(), 0, ' ', '&nbsp;');
            $basket = View::make('partials.head-cart', ['basket' => $this->basket]);

            return response()->json([
                'total' => $total,
                'count' => $count,
                'basket' => $basket->render(),
                'cur_sku' => $sku,
                'cur_count' => $cur_count,
                'cur_total' => $cur_total,
            ]);
        } else {
            return response()->json(['error' => 'Товар не найден']);
        }
    }

    /**
     * Delete from basket
     * @param  Request $request
     * @return Response
     */
    public function del(Request $request)
    {
        $sku = $request->input('sku');

        if ($item = Product::where(['name' => $sku])->first()) {
            $total = $count = $cur_count = $cur_total = 0;
            foreach ($this->basket->contents() as $item) {
                if ($item->name == $sku) {
                    if ($item->quantity > 1) {
                        $item->quantity -= 1;
                        $cur_count = $item->quantity;
                        $cur_total = $item->price * $item->quantity;
                    } else {
                        $item->remove();
                        $cur_count = 0;
                        $cur_total = 0;
                    }
                }
            }
            $count = $this->basket->totalItems();
            $total = number_format($this->basket->total(), 0, ' ', '&nbsp;');
            $basket = View::make('partials.head-cart', ['basket' => $this->basket]);

            return response()->json([
                'total' => $total,
                'count' => $count,
                'basket' => $basket->render(),
                'cur_sku' => $sku,
                'cur_count' => $cur_count,
                'cur_total' => $cur_total,
            ]);
        } else {
            // TODO: use Laravel locaization
            return response()->json(['error' => 'Товар не найден']);
        }
    }

    /**
     * Basket index page
     * @return View
     */
    public function index()
    {
        $list = [];
        foreach ($this->basket->contents() as $item) {
            $list[] = $item->id;
            $count[$item->id] = $item->quantity;
        }

        $items = Product::with('images')->find($list);

        foreach ($items as $item) {
            $item->count = $count[$item->id];
        }

        return View::make('cart', [
            'items' => $items,
            'total' => $this->basket->total()
        ]);
    }

    /**
     * Basket order method
     * @param  CartOrderPostRequest $request
     * @return View
     */
    public function order(CartOrderPostRequest $request)
    {
        // Detect city for delivery cost calculations
        $city = CityService::getCurrent();

        $list = [];
        foreach ($this->basket->contents() as $item) {
            $list[] = $item->id;
            $count[$item->id] = $item->quantity;
        }

        $items = Product::with('images')->find($list);

        foreach ($items as $item) {
            $item->count = $count[$item->id];
        }

        return View::make('order', [
            'items' => $items,
            'total' => $this->basket->total(),
            'city' => $city->name,
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'name' => $request->input('name'),
            'delivery' => CityService::getDeliveryCost($this->basket->total()),
        ]);
    }

    /**
     * Complete order
     * @param  Request $request
     * @return View
     */
    public function complete(Request $request)
    {
        Mail::send('email.order', [
                'name' => $request->input('name'),
                'phone' => $request->input('phone'),
                'email' => $request->input('email'),
                'city' => $request->input('city'),
                'street' => $request->input('street'),
                'house' => $request->input('house'),
                'flat' => $request->input('flat'),
                'pay-type' => $request->input('pay-type'),
                'items' => $this->basket->contents(),
                'total' => $this->basket->total(),
            ], function ($message) {
                $message->subject('Ecom shop order');
                $message->from(Config::get('app.contact_email'), 'Ecom shop');
                $message->to(Config::get('app.contact_email'));
            });

        // get total count
        $total = $this->basket->total();

        // get delivery cost
        $deliveryCost = CityService::getDeliveryCost($this->basket->total());

        // collecting order
        $list = [];
        foreach ($this->basket->contents() as $item) {
            $list[] = $item->id;
            $count[$item->id] = $item->quantity;
            $this->basket->remove($item->identifier);
        }

        // get ordered products
        $items = Product::with('images')->find($list);

        // set item count
        foreach ($items as $item) {
            $item->count = $count[$item->id];
        }

        return View::make('complete', [
            'items' => $items,
            'total' => $total,
            'delivery' => $deliveryCost,
        ]);
    }
}
