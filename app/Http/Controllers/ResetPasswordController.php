<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendNewPasswordMail;

class ResetPasswordController extends Controller
{

    
    public function showResetForm()
    {
        return view('reset_password');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        // Check if email exists
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                "success" => false,
                "message" => "No user associated with this email!"
            ]);
        }

        // Generate strong random password
        $newPassword = $this->generateStrongPassword();

        // Update user password
        $user->update([
            'password' => Hash::make($newPassword)
        ]);

        // Email new password to user
        Mail::to($user->email)->send(new SendNewPasswordMail($user, $newPassword));

        return response()->json([
            "success" => true,
            "message" => "Password reset successful. A new password has been sent to the user's email."
        ]);
    }

    // Strong password generator
    private function generateStrongPassword($length = 12)
    {
        return substr(str_shuffle(
            'ABCDEFGHIJKLMNOPQRSTUVWXYZ' .
            'abcdefghijklmnopqrstuvwxyz' .
            '0123456789' .
            '!@#$%^&*()_+=-{}[]'
        ), 0, $length);
    }
}
