<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\EnrollmentRequest;
use App\Models\Student;
use App\Models\Program;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'requests_total' => EnrollmentRequest::count(),
            'requests_pending' => EnrollmentRequest::where('status', 'pending')->count(),
            'requests_review' => EnrollmentRequest::where('status', 'review')->count(),
            'requests_approved' => EnrollmentRequest::where('status', 'approved')->count(),
            'requests_rejected' => EnrollmentRequest::where('status', 'rejected')->count(),
            'students' => Student::count(),
            'programs' => Program::count(),
        ];

        $recentRequests = EnrollmentRequest::with('program')
            ->orderByDesc('created_at')
            ->limit(10)
            ->get();

        return view('admin.dashboard', compact('stats','recentRequests'));
    }
}


