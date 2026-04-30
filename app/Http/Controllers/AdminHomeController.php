<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Quote;
use App\Models\Task;
use App\Models\User;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class AdminHomeController extends Controller
{
    public function index()
    {
        // ========================
        // KPI CARDS DATA
        // ========================

        $totalProjects = Project::count();
        $totalTasks = Task::count();
        $totalQuotes = Quote::count();
        $activeProjects = Project::where('status', 'in_progress')->count();
        $pendingQuotes = Quote::where('status', 'pending')->count();
        // $totalRevenue = Quote::where('status', 'completed')->sum('grand_total');
        $totalRevenue = Project::where('status','completed')
                            ->with("quote")
                            ->get()
                            ->sum('quote.grand_total');
        $overdueTasks = Task::where('created_at', '<', now())
                            ->where('status', '!=', 'Completed')
                            ->count();

        // ========================
        // PROJECT STATUS BAR CHART
        // ========================

        $projectStatus = Project::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // ========================
        // MONTHLY PROJECTS LINE CHART
        // ========================

        $monthlyProjects = Project::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('count(*) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // ========================
        // QUOTE STATUS PIE CHART
        // ========================

        $quoteStatus = Quote::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // ========================
        // DEVELOPER WORKLOAD BAR CHART
        // ========================

        $developerWorkload = Task::selectRaw('users.sdms_id, COUNT(tasks.id) as total')
            ->join('users', 'tasks.assigned_to', '=', 'users.id')
            ->where('tasks.status', '!=', 'completed')
            ->groupBy('users.sdms_id')
            ->pluck('total', 'users.sdms_id');


        return view('admin_home', compact(
            'totalProjects',
            'totalQuotes',
            'totalTasks',
            'activeProjects',
            'pendingQuotes',
            'totalRevenue',
            'overdueTasks',
            'projectStatus',
            'monthlyProjects',
            'quoteStatus',
            'developerWorkload'
        ));
    }
}





