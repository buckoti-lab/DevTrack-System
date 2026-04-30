<?php

namespace App\Http\Controllers;

use PDF;
use Illuminate\Http\Request;
use App\Models\Announcement;

class AnnouncementController extends Controller
{
/*     public function index()
    {
        return view('announcements');
    } */
      
    public function index(Request $request)
    {
        $search = $request->search;

        $announcements = Announcement::when($search, function($query) use ($search){
            $query->where('content', 'like', "%$search%");
        })->get();

        // If AJAX request → return JSON only
        if ($request->ajax()&& $request->has('search')) {
           return response()->json(['announcements' => $announcements]);
        }

        if(auth()->user()->role !== "admin"){
            return view('client_announcements', compact('announcements'));
        }
        // Normal load
        return view('announcements', compact('announcements'));
    }
    

    // STORE NEW USER
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required',
            'target' => 'required',
            'expires_at' => 'required',
        ]);

        $announcement = Announcement::create([
            'content' => $request->content,
            'target' => $request->target,
            'expires_at' => $request->expires_at,
            'created_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Announcement added successfully',
            'announcement' => $announcement
        ]);
    }

    // UPDATE USER
    public function update(Request $request, $id)
    {
        $announcement = Announcement::findOrFail($id);

        $request->validate([
            "content"=>"required",
            "target"=>"required",
            "expires_at"=>"required"
        ]);

        $announcement->update([
            'content' => $request->content,
            'target' => $request->target,
            'expires_at' => $request->expires_at,
            'updated_by' => auth()->id(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Announcement updated successfully',
            'announcement' => $announcement
        ]);
    }

    // DELETE USER
    public function delete($id)
    {
        Announcement::destroy($id);

        return response()->json([
            'success' => true,
            'message' => 'Announcement deleted successfully'
        ]);
    }


    // PDF Export
    public function exportPDF(Request $request)
    {
    $query = Announcement::query();

    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('content', 'like', "%$search%");
        });
    }

    $announcements = $query->orderBy('id', 'desc')->get();

    $printedBy = auth()->user()->first_name . ' ' . auth()->user()->last_name;
    $date = now()->format('Y-m-d H:i:s');

    $pdf = PDF::loadView('/pdf/announcements-pdf', compact('announcements', 'printedBy', 'date'));

    return $pdf->download('announcements_' . now()->format('Ymd_His') . '.pdf');
   }

}
