<?php

namespace App\Http\Controllers\Backend;

use App\Models\AdminUser;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Jenssegers\Agent\Facades\Agent;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Contracts\DataTable;

class AdminUserController extends Controller
{
    Public function AdminList()
    {
        $admin_users = AdminUser::whereNotIn('id',[auth()->id()])->get();
        return view('backend.admin-managements.index',compact('admin_users'));
    }

    public function RegisterPage()
    {
        return view('backend.admin-managements.create');
    }

    public function AdminRegister(Request $request)
    {
        $this->CheckValidate($request);
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
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,  
            'phone' => 'required|unique:users,phone,'.$id,
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password'
        ]);
        $admin_user = AdminUser::findOrFail($id);
        $admin_user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password)
        ]);
        return redirect()->route('admin-managements')->with('success_msg',"Updating Success");
    }

    public function Delete($id)
    {
        $user = AdminUser::findOrFail($id);
        $user->delete();
        return redirect()->route('admin-managements')->with('success_msg',"Deleting Success");
    }

    private function CheckValidate(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password'
        ]);
    }
}
