<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //
    public function dashboard(){
        $posts=BlogPost::count();
        return view('admin.dashboard',compact('posts'));
    }

    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if ($admin && Hash::check($request->password, $admin->password)) {
            session(['admin_id' => $admin->id]);
            return redirect()->route('admin.dashboard');
        }
        return back()->withErrors(['Invalid credentials']);
    }

    public function logout() {
         session()->forget('admin_id');
        return redirect()->route('admin.login');
    }
}
