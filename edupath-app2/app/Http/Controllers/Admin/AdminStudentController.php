<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminStudentController extends Controller
{
    public function index(Request $request): View
    {
        $query = Student::with(['user', 'program']);

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%$search%")
                  ->orWhere('last_name', 'like', "%$search%")
                  ->orWhere('student_number', 'like', "%$search%");
            });
        }

        if ($programId = $request->integer('program_id')) {
            if ($programId > 0) {
                $query->where('program_id', $programId);
            }
        }

        $students = $query->orderByDesc('created_at')->paginate(15)->withQueryString();
        $programs = \App\Models\Program::orderBy('name')->get();

        return view('admin.students.index', compact('students', 'programs'));
    }
}
