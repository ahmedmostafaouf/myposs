<?php

namespace App\Http\Controllers\Dashboard\Client;

use App\Category;
use App\Client;
use App\Http\Controllers\Controller;
use App\Order;
use App\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function create(Client $client)
    {
        $categories=Category::with('products')->get();
        $orders = Order::with('products')->paginate(5);
      return view('dashboard.clients.orders.create',compact('categories','client','orders'));
    }


    public function store(Request $request ,Client $client)
    {
        $request ->validate([
            'products' =>'required|array',
        ]);
       $this->attach_order($request,$client);
        session()->flash('success',__('site.add_successfully'));
        return redirect()->route("dashboard.orders.index");


    }

    public function edit(Client $client,Order $order)
    {
        $categories=Category::with('products')->get();
        $orders = Order::with('products')->paginate(5);
        return view('dashboard.clients.orders.edit',compact('order','client','categories','orders'));
    }

    public function update(Request $request,Client $client, Order $order)
    {
        $request ->validate([
            'products' =>'required|array',
        ]);
        $this->delete_order($order);
       $this->attach_order($request,$client);
        session()->flash('success',__('site.updated_successfully'));
        return redirect()->route("dashboard.orders.index");

    }

    private function attach_order($request,$client){
        $order=$client->orders()->create([]); // one to many
        $order->products()->attach($request->products); // many to many
        $total_price=0;
        foreach ($request->products as $id=>$quantity){
            $product=Product::FindOrFail($id);
            $total_price +=$product->sale_price * $quantity['quantity'] ;
            $product->update([
                'stock'=>$product->stock - $quantity['quantity']
            ]);
        }//end fo foreach
        $order->update([
            'total_price' => $total_price
        ]);
    }
    private  function delete_order($order){
        foreach ($order->products as $product){
            $product ->update([
                //اجيب الكونتتت واجمعها عليها
                'stock'=> $product ->stock + $product->pivot->quantity , // انا هما جبت المخزن وزودت عليه الي همسحه ع حسب الكميه
            ]);
        }
        $order->delete();
    }

}
