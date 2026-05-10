<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function index()
    {

        return view('index');
    }


    public function getLogin()
    {
        return view("login");
    }

    public function postLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('email', $request->username)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            Auth::login($user);

            return response()->json([
                'success' => true,
                'role' => $user->role
            ]);  

        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
    }

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $sessionId = session()->getId();

            // Log user out
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('get.login');
    }
}
