<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Category;
use App\Product;
use App\ProductCategory;
use Illuminate\Support\Facades\Redirect;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
      //return view('home');
      return Redirect::to('/');
    }
    public function home(){
      $page_title ='Ecommerce | Front Page';
      $allCategory = Category::select('*')->where('is_deleted','0')->get();
      $allProduct=Product::select('*')->where('is_deleted','0')->get();
      return view('index')
      ->with('page_title',$page_title)
      ->with('allCategory',$allCategory)
      ->with('allProduct',$allProduct);
    }
    public function addToCart(Request $request){
      $product_id=trim($request->get('product_id'));
      $quantity=trim($request->get('quantity'));
      $getParticularProduct=Product::where('id',$product_id)->first();
      // echo "<pre>";
      // print_r($getParticularProduct); die;
      $addToCart=\Cart::add(array(
        'id' => $getParticularProduct->id,
        'name' => $getParticularProduct->product_name,
        'price' => $getParticularProduct->usd_price,
        'quantity' => 1,
        'attributes' => array(
            'image' => $getParticularProduct->feature_image,
            'slug' => $getParticularProduct->product_slug
        )
      ));
      if($addToCart)
      {
        echo "1";
      }
      else
      {
        echo "2";
      }
    }
    public function cart(Request $request){
      $page_title ='Ecommerce | Cart';
      $cartCollection = \Cart::getContent();
      //dd($cartCollection);
      // echo "<pre>";
      // print_r($cartCollection);
      return view('shoping-cart')
      ->with('page_title',$page_title)
      ->with('cartCollection',$cartCollection);
    }
    public function updateCart(Request $request)
    {
      $product_id=trim($request->get('product_id'));
      $quantity=trim($request->get('quantity')); 
      $updateCart=\Cart::update($product_id,
        array(
            'quantity' => array(
            'relative' => false,
            'value' => $quantity
            ),
        ));
      if($updateCart)
      {
        echo "1";
      }
      else
      {
        echo "0";
      }  
    }
    public function deleteProduct(Request $request)
    {
      $product_id=trim($request->get('product_id'));
      //$quantity=trim($request->get('quantity')); 
      $removeProduct=\Cart::remove($product_id);
      if($removeProduct)
      {
        echo "1";
      }
      else
      {
        echo "0";
      }  
    }
}
