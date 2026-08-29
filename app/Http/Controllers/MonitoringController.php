<?php

namespace App\Http\Controllers;

use App\Models\NotifikasiLog;
use Illuminate\Support\Facades\DB;

class MonitoringController extends Controller
{
    public function index()
    {
        $logs = NotifikasiLog::with('jadwal')
            ->latest()
            ->paginate(20);

        $pendingJobs = DB::table('jobs')->count();

        $failedJobs = DB::table('failed_jobs')->count();

        $successNotif = NotifikasiLog::where('status','berhasil')->count();
        $failedNotif = NotifikasiLog::where('status','gagal')->count();

        return view('monitoring.index', compact(
            'logs',
            'pendingJobs',
            'failedJobs',
            'successNotif',
            'failedNotif'
        ));
    }
}
