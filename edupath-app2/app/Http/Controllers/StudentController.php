<?php

namespace App\Http\Controllers;

use App\Models\EnrollmentRequest;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class StudentController extends Controller
{
    public function dashboard(Request $request): View
    {
        $user = $request->user();
        $student = Student::where('user_id', $user->id)->first();
        
        $enrollmentRequests = EnrollmentRequest::where('email', $user->email)
            ->with('program')
            ->orderByDesc('created_at')
            ->get();

        return view('student.dashboard', compact('student', 'enrollmentRequests'));
    }
}
