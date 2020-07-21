<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\Product;
use App\Traits\ImageTraits;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    use ImageTraits;

    public function index(Request $request)
    {
        $categories = Category::all();
        $products=Product::when($request->search,function ($q) use($request){
            return $q->whereTranslationLike('name','%'.$request -> search.'%');
        })->when($request->category_id,function ($q)use ($request){
            return $q ->where('category_id',$request ->category_id);
        })->latest()->paginate(5);
        return view('dashboard.products.index',compact('categories','products'));

    }


    public function create()
    {
               $categories=Category::all(); // because i need this in relation to show categories in create page
        return view('dashboard.products.create',compact('categories'));
    }


    public function store(Request $request)
    {
        //method traits photo
        $file_name=$this->SaveImages($request->image,'image/products');
        $rules=
            [
            'category_id'=>'required'
            ];
                foreach (config('translatable.locales')as $locale){
                    $rules+=[$locale.'.name'=>['required',Rule::unique('product_translations','name')]];
                    $rules+=[$locale.'.description'=>['required',Rule::unique('product_translations','name')]];
                }
                $rules+=[
                    'purchase_price'=>'required',
                    'sale_price'=>'required',
                    'stock'=>'required',

                    ];
                $request->validate($rules);

        $request_date=$request->except(['image']); // all of data
        $request_date['image'] = $file_name;
        $products=Product::create($request_date);
        session()->flash('success',__('site.add_successfully'));
        return redirect()->route("dashboard.products.index");
    }


    public function edit(Product $product)
    {
        $categories=Category::all();
       return view('dashboard.products.edit',compact('product','categories'));
    }


    public function update(Request $request, Product $product)
    {
        $rules=['category_id'=>'required'];
        foreach (config('translatable.locales')as $locale){
            $rules+=[$locale.'.name'=>['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]];
            $rules+=[$locale.'.description'=>['required',Rule::unique('product_translations','name')->ignore($product->id,'product_id')]];
        }
        $rules+=[
            'purchase_price'=>'required',
            'sale_price'=>'required',
            'stock'=>'required',

        ];
        $request->validate($rules);
        $file_name=$this->SaveImages($request->image,'image/products');
        $request_date=$request->except(['image']);
        $request_date['image'] = $file_name;
        $product->update($request_date);
        session()->flash('success',__('site.add_successfully'));
        return redirect()->route("dashboard.products.index");
    }


    public function destroy(Product $product)
    {

          $product -> delete();
        session()->flash('success',__('site.delete_successfully'));
        return redirect()->route("dashboard.products.index");
    }
}
