<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Generate;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();
        return view('backend.user-managements.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('backend.user-managements.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password'
        ]);
        $user_email = User::where('email',$request->email)->first();
        $user_phone = User::where('phone',$request->phone)->first();
        if($user_email){
            return redirect()->back()->with('error_msg',"Email is already taken!");
        }
        if($user_phone){
            return redirect()->back()->with('error_msg',"Phone is already taken!");
        }
        DB::beginTransaction();
        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            Wallet::firstOrCreate(
                [
                'user_id' => $user->id
                ],
                [
                'account_number' => Generate::accountNumber(),
                'amount' => 0
                ]
            );
            DB::commit();
            return redirect()->route('users.index')->with("success_msg","New User Created.");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error_msg","Something went Wrong!");
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('backend.user-managements.edit',compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->CheckValidate($request,$id);
        $user = User::findOrFail($id);
        DB::beginTransaction();
        try {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password)
            ]);
            Wallet::firstOrCreate(
                [
                'user_id' => $user->id
                ],
                [
                'account_number' => Generate::accountNumber(),
                'amount' => 0
                ]
            );
            DB::commit();
            return redirect()->route('users.index')->with('success_msg',"Updating Success");
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with("error_msg","Something went Wrong!");        
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('users.index')->with('success_msg',"Updating Success");
    }

    private function CheckValidate(Request $request,$id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,'.$id,  
            'phone' => 'required|unique:users,phone,'.$id,
            'password' => 'required|min:6|max:20',
            'password_confirmation' => 'required|same:password'
        ]);
    }
}
