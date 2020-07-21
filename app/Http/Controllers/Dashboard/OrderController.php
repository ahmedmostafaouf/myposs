<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
  public function index(Request $request){
      $products=Product::all();
      $orders=Order::whereHas('client' ,function ($q) use($request){
          return $q ->where('name','like','%'.$request -> search.'%');
      })->latest()->paginate(5);
     return view('dashboard.orders.index',compact('orders'));
  }
  public function products(Order $order){
      $products=$order->products;
      return view('dashboard.orders._products',compact('products','order'));
  }
  public function destroy(Order $order){
      //اما احذف يقوم واخد الكميه  الي حذقتها واروح اذودها ف الاستوك المخزن
      foreach ($order->products as $product){
          $product ->update([
              //اجيب الكونتتت واجمعها عليها
              'stock'=> $product ->stock + $product->pivot->quantity , // انا هما جبت المخزن وزودت عليه الي همسحه ع حسب الكميه
          ]);
      }
      $order->delete();
      session()->flash('success',__('site.delete_successfully'));
      return redirect()->route("dashboard.orders.index");


  }
}
