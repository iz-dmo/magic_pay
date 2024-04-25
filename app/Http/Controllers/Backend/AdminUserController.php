<?php

namespace App\Http\Controllers\Backend;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    Public function AdminList()
    {
        $admin_users = AdminUser::all();
        return view('backend.admin-managements.index',compact('admin_users'));
    }

    public function AdminRegister(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:6|max:20'
        ]);
        $admin_user_email = AdminUser::where('email',$request->email)->first();
        $admin_user_phone = AdminUser::where('phone',$request->phone)->first();
        if($admin_user_email || $admin_user_phone){
            return redirect()->back()->with('error_msg',"Your Email or Phone is already taken!Please Try Again");
        }
        AdminUser::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);
        return redirect()->route('admin-managements')->with("success_msg","New Admin Created.");
    }

    public function AdminEdit(string $id)
    {
        $admin_user = AdminUser::findOrFail($id);
        return view('backend.admin-managements.edit',compact('admin_user'));
    }

    public function AdminUpdate(Request $request,$id)
    {
        $admin_user = AdminUser::findOrFail($id);
        $admin_user->update($request->all());
        return redirect()->route('admin-managements')->with('success_msg',"Updating Success");
    }

    public function Delete($id)
    {
        $user = AdminUser::findOrFail($id);
        $user->delete();
        return redirect()->route('admin-managements')->with('success_msg',"Deleting Success");
    }
}
