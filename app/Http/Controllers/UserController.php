<?php
namespace App\Http\Controllers;

use PDF;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

    public function index(Request $request)
    {
       $search = $request->search;

       $users = User::when($search, function($query) use ($search){
       $query->where('first_name', 'like', "%$search%")
              ->orWhere('second_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%");
       })->get();

       // If AJAX request → return JSON only
       if ($request->ajax()&& $request->has('search')) {
          return response()->json(['users' => $users]);
        }

        // Normal load
        return view('users', compact('users'));
    }



    public function generateSdmsId($user){
        $user_id = $user->id;
        $user_role = $user->role;

        $update = $user->update([
             'sdms_id'=> "SDMS-".strtoupper($user_role[0]). str_pad($user_id, 4, '0', STR_PAD_LEFT)
        ]);
        if(!$update){
           return false;  
        }
        return true;
    }

    // STORE NEW USER
    public function store(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:users',
            'first_name' => 'required',
            'second_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'role' => 'required',
            'password' => 'required|min:6'
        ]);

        $user = User::create([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'sex' => $request->sex,
            'role' => $request->role,
            'created_by' => auth()->id(),
            'password' => Hash::make($request->password)
        ]);
        
        // $user->refresh();

        $this->generateSdmsId($user);

        return response()->json([
            'success' => true,
            'message' => 'User added successfully',
            'user' => $user
           ]);
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $user->update([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'second_name' => $request->second_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'sex' => $request->sex,
            'role' => $request->role
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'User updated successfully',
            'user' => $user
        ]);
    }

    // DELETE USER
    public function delete($id)
    {
        User::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'User deleted successfully'
        ]);
    }


    // PDF Export
    public function exportPDF(Request $request)
    {
    $query = User::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('first_name', 'like', "%$search%")
              ->orWhere('second_name', 'like', "%$search%")
              ->orWhere('last_name', 'like', "%$search%")
              ->orWhere('email', 'like', "%$search%")
              ->orWhere('phone', 'like', "%$search%");
        });
    }

    $users = $query->orderBy('id', 'desc')->get();

    $printedBy = auth()->user()->first_name . ' ' . auth()->user()->last_name;
    $date = now()->format('Y-m-d H:i:s');

    $pdf = PDF::loadView('/pdf/users-pdf', compact('users', 'printedBy', 'date'));

    return $pdf->download('users_' . now()->format('Ymd_His') . '.pdf');
   }

}
