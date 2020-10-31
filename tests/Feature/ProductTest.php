<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use \App\Models\Product;
use \App\Models\Light;
use \App\Models\Brand;
use \App\Models\Family;
use \App\Models\Collection;
use \App\Models\Order;
use \App\Models\City;
use \App\Models\Delivery;
use \App\Models\Payment;


class ProductTest extends TestCase
{

	// use DatabaseTransactions;
	use DatabaseMigrations;
	
	/**
	 * Product instance
	 * @var Product
	 */
	private $product;

	/**
	 * @test product creation
	 */
    public function creates_a_product()
    {
    	// create a Brand
    	$brand = new Brand(['name' => 'Brand #1']);
    	$brand->save();
    	$this->assertEquals($brand->id, 1);

    	// create a Product
    	$product = new Product([
			'name' => 'Product #1',
			'price' => 1000
		]);

    	// update product with 1-n relation
    	$product->brand()->associate($brand->id);
    	$test = $product->save();
    	$this->assertTrue($test);

    	// create a Family
    	$family = new Family(['name' => 'Family #1']);
    	$family->save();
    	$this->assertEquals($family->id, 1);

    	// create a Collection
    	$collection = new Collection(['name' => 'Collection #1']);
    	$collection->save();
    	$this->assertEquals($collection->id, 1);

    	// create a lustre (Light)
		$light = new Light(['materials' => 'glass & steel']);

		// update lustre with 1-n relations
		$light->family()->associate($family->id);
		$light->collection()->associate($collection->id);

		// update lustre with 1-1 relation
		$light->product()->associate($product->id);

		// save the lustre
		$light->save();
    	$this->assertEquals($light->id, 1);
		
		$this->$product = $product;
    }

	/**
	 * @test cart creation
	 */
    public function creates_a_cart() {
		
		// add a product to cart
    	Cart::add($this->product, 1);
	
    	// check if total equals to 1000
    	$this->assertEquals(Cart::getTotal(), 1000);
    }
	
	// /**
	//  * @test if discount applies
	//  */
    // public function applies_discount()
    // {
	// 	// create a discount
    // 	$discount = new Discount(['active' => 1, 'amount' => '10', 'price_from' => 500, 'price_to' => 1500]);
	// 
	// 	// create a cart
    // 	$this->creates_a_cart();
	// 
    // 	// check if total equals -10%
	// 	$this->assertEquals(900, Cart::getTotal());
    // }
	// 
	// 
    // /**
    //  * @test order creation
    //  */
    // public function creates_an_order()
    // {
	// 	// city
	// 	$city = new City(['name' => 'Test city']);
	// 	
	// 	// payment type
	// 	$payment = new Payment(['name' => 'Test payment']);
	// 	
	// 	// delivery type
	// 	$delivery = new Delivery(['name' => 'Test delivery']);
	// 	
    // 	// create an order
    // 	$order = new Order(["city" => $city, "address" => "231 Test street", "test@email.address", "+1 234 567 89 01", "Test comments", $payment, $delivery]);
	// 
    // 	// place order
    // 	$order->place();
	// 	
	// 	// clear cart
	// 	Cart::clear();
	// 
    // }
	// 

}
