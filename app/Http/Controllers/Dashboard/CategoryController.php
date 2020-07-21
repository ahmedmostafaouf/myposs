<?php

namespace App\Http\Controllers\Dashboard;

use App\Category;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{

    public function index(Request $request)
    {
        $categories=Category::when($request ->search ,function ($q) use($request){

            return $q ->whereTranslationLike('name','%'.$request ->search.'%');

        })->latest()->paginate(5);
        return view('dashboard.categories.index',compact('categories'));
    }// end of index


    public function create()
    {
          return view('dashboard.categories.create');
          
    } //end of create


    public function store(Request $request)
    {
        $rules=[];
        foreach (config('translatable.locales') as $locale){
            // ar.nasession()->flash('success',__('site.add_successfully'));
            //        return redirect()->route("dashboard.categories.index");me => required  and unique(table name ,column)
            $rules +=[$locale . '.name'=>['required',Rule::unique('category_translations','name')]];

          }//end of foreach
       $request ->validate($rules);
        $category=Category::create($request->all());
        session()->flash('success',__('site.add_successfully'));
        return redirect()->route("dashboard.categories.index");
    }//end of story





    public function edit(Category $category)
    {
        return view('dashboard.categories.edit',compact('category'));
    }//end of edit


    public function update(Request $request, Category $category)
    {
        $rules=[];
        foreach (config('translatable.locales') as $locale){
            // ar.name => required  and Rule::unique(table name ,column or unique:table,name column )
            $rules +=[$locale . '.name'=>['required',Rule::unique('category_translations','name')->ignore($category->id,'category_id')]];
          } //end of foreach
        $request -> validate($rules);
        $category->update($request->all());
        session()->flash('success',__('site.edit_successfully'));
        return redirect()->route("dashboard.categories.index");
    }//end of update


    public function destroy(Category $category)
    {
        $category->delete();
        session()->flash('success',__('site.delete_successfully'));
        return redirect()->route("dashboard.categories.index");
    }// end of destroy
}
