<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Traits\ImageTraits;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    use ImageTraits;
    public function _construct(){
        $this->middleware(['permission:read_users'])->only('index');
        $this->middleware(['permission:create_users'])->only('create');
        $this->middleware(['permission:update_users'])->only('edit');
        $this->middleware(['permission:delete_users'])->only('delete');
    }

    public function index(Request $request)
    {
        $users=User::whereRoleIs('admin')->when($request->search,function ($q) use($request){
            return $q->where('first_name','like','%'.$request -> search.'%')->orwhere('last_name','like','%'.$request -> search.'%');
        })->latest()->paginate(5);
        return view('dashboard.users.index',compact('users'));
    }

    public function create()
    {
        return view('dashboard.users.create');
    }


    public function store(Request $request)
    {
             $file_name=$this->SaveImages($request->photo,'image/users');
        // دي ال فالديت الي موجوده في الفولد اللغه
          $request->validate([
             'first_name' =>'required|max:20',
             'last_name' =>'required|max:20',
             'email' =>'required',
             'password' =>'required|confirmed',
             'permission' =>'required|min:1',
          ]);

          $request_date=$request->except(['password']);//هجيب كله معاد الباص
          $request_date['password'] = bcrypt($request->password);// هاخد حقل الباص واعمله هاش
          $request_date['photo'] = $file_name;
          $user=User::create($request_date);// ضيفلي بقي كله بعد اما عملته هاش
          $user->attachRole('admin');
          $user->syncPermissions($request->permission); // بديلو الاسم الي ف الشيك
          session()->flash('success',__('site.add_successfully'));
          return redirect()->route("dashboard.index");
    }

    public function edit($user_id)
    {
        $user =User::find($user_id);
        if(!$user){
            return redirect()->back();
        }

        $user = User::get()->find($user_id);
             return view('dashboard.users.edit',compact('user'));
    }


    public function update(Request $request,$user_id)
    {
        // دي ال فالديت الي موجوده في الفولد اللغه
        $request->validate([
            'first_name' =>'required|max:20',
            'last_name' =>'required|max:20',
            'email' =>'required',
            'permission' =>'required|min:1',
            'photo'      =>'required',
        ]);

        $user =User::find($user_id);
        if(!$user){
            return redirect()->back();
        }
        if($user->photo !='default.png'){
            Storage::disk('users')->delete('/users/'.$user->photo);
        }
        $file_name=$this->SaveImages($request->photo,'image/users');
        $request_data = $request->except(['permissions']);
        $request_data['photo']=$file_name;
          $user->update($request_data);

        $user->syncPermissions($request->permission);
          session()->flash('success',__('site.update_successfully'));
             return redirect()->route("dashboard.index");
    }


    public function delete($user_id)
    {
        $user =User::find($user_id);
        if(!$user){
            return redirect()->back();
        }
        if($user->photo !='default.png'){
            Storage::disk('users')->delete('/users/'.$user->photo);
        }
        $user ->delete();
        session()->flash('success',__('site.delete_successfully'));
        return redirect()->route("dashboard.index");
    }
}
