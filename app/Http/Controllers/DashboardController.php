<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function dashboardApi(Request $request)
    {
        // Validate request
        if (!$request->isMethod('post') || !Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized or invalid request.'
            ], 401);
        }

        $user = Auth::user();

        // Profile image handling
        $profileImage = $user->profile_picture
            ? "uploads/images/profile_pictures/{$user->profile_picture}"
            : "uploads/images/profile_pictures/default_profile_picture.jpg";

        $imageUrl = Storage::disk('public')->exists($profileImage)
            ? Storage::url($profileImage)
            : null;

       

        // Build JSON response
        return response()->json([
            'success' => true,
            'username' => $user->first_name,
            'email' => $user->email,
            'first_name' => $user->first_name,
            'second_name' => $user->second_name,
            'last_name' => $user->last_name,
            'phone' => $user->phone,
            'sex' => $user->sex,
            'image' => $imageUrl
        ]);
    }
}
