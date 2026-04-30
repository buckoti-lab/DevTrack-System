<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EditProfileController extends Controller
{
    //
    public function edit()
    {
        return view('edit_profile');
    }

public function update(Request $request)
{
    if (!Auth::check()) {
        return response()->json([
            'success' => false,
            'message' => 'Unauthorized.'
        ], 401);
    }

    if (!$request->isMethod('put')) {
        return response()->json([
            'success' => false,
            'message' => 'Invalid request method.'
        ], 400);
    }

    $user = Auth::user();

    // Validation
    $request->validate([
        'first_name' => 'required|string|max:255',
        'second_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'phone' => 'required|string|max:15',
        'sex' => 'required|in:Male,Female',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'profileimage' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    // Update fields
    $user->first_name = $request->first_name;
    $user->second_name = $request->second_name;
    $user->last_name = $request->last_name;
    $user->phone = $request->phone;
    $user->sex = $request->sex;
    $user->email = $request->email;

    // Profile picture (optional)
    if ($request->hasFile('profileimage')) {
        $picture = $request->file('profileimage');
        $pictureName = time() . '.' . $picture->getClientOriginalExtension();
        $picture->move(public_path('storage/images/uploads/profile_pictures'), $pictureName);

        $user->profile_picture = $pictureName;
    }

    $user->save();

    return response()->json([
        'success' => true,
        'message' => 'Profile updated successfully!'
    ]);
}

}
