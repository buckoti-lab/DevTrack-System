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
/*         if (Auth::check()) {
/*             $role = "admin";
            return $this->redirectUser($role);
            //return $this->redirectUser(Auth::user()->$role); 

            if(auth()->user()->role === "Adminj"){
                 return redirect()->to('dashboard');
            }else {
                 return  redirect()->to('client_dashboard');
           }
        } */ 

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

/*             if($user->role === "Admin"){
               return redirect()->to('dashboard');
            }else {
                return  redirect()->to('client_dashboard');
           } */
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
    }

/*     private function redirectUser($role)
    {
        if ($role === 'Admin') return redirect()->to('dashboard');
        if ($role === 'Other') return redirect()->to('client_dashboard');
        // return redirect()->to('dashboard');
    } */

    public function logout(Request $request)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $sessionId = session()->getId();

            // Update session in DB
            /*DB::table('user_sessions')
                ->where('user_id', $userId)
                ->where('session_id', $sessionId)
                ->update(['is_online' => 0]);*/

            // Log user out
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
        }

        return redirect()->route('get.login');
    }
}
