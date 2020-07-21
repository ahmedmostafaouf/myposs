<?php

namespace App\Http\Controllers\Dashboard;

use App\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use function foo\func;

class ClientController extends Controller
{

    public function index(Request $request)
    {
          $clients=Client::when($request ->search,function ($q) use($request){
              return $q ->where('name','like','%'.$request ->search.'%')
                  ->orwhere('phone','like','%'.$request ->search.'%')
                  ->orwhere('address','like','%'.$request ->search.'%');
          })->latest()->paginate(2);
          return view('dashboard.clients.index',compact('clients'));
    }


    public function create()
    {
        return view('dashboard.clients.create');
    }
    public function store(Request $request)
    {
        $request ->validate([
            'name'=>'required',
            'phone'=>'required|min:1',
            'phone.0'=>'required',
            'address'=>'required',
        ]);
        $request_data=$request->all();
        // another way to phone replace in index view
        $request_data['phone']=array_filter($request->phone);
        $clients = Client::create($request_data);
        session()->flash('success',__('site.add_successfully'));
        return redirect()->route("dashboard.clients.index");
    }



    public function edit(Client $client)
    {
       return view('dashboard.clients.edit',compact('client'));
    }

    public function update(Request $request, Client $client)
    {
        $request ->validate([
            'name'=>'required',
            'phone'=>'required|min:1',
            'phone.0'=>'required',
            'address'=>'required',
        ]);
        $request_data=$request->all();
        // another way to phone replace in index view
        $request_data['phone']=array_filter($request->phone);
        $client ->update($request_data);
        session()->flash('success',__('site.edit_successfully'));
        return redirect()->route("dashboard.clients.index");
    }

    public function destroy(Client $client)
    {
        $client->delete();
        session()->flash('success',__('site.delete_successfully'));
        return redirect()->route("dashboard.categories.index");
    }
}
