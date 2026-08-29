<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;

class AdminActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::with('user')
            ->where('module', '!=', 'Manajemen User')
            ->latest()
            ->paginate(20);

        return view('admin.logs.index', compact('logs'));
    }
}
