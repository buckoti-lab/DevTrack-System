<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangepasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        // Validate request
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:8',
            'repeated_password' => 'required|same:new_password'
        ]);

        $user = Auth::user();

        // Check old password
        if (!Hash::check($request->old_password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Old password is incorrect.'
            ]);
        }

        // Update new password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json([
            'success' => true,
            'message' => "Password updated successful. Please login."
        ]);
    }
}
