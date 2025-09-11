<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminCourseController extends Controller
{
    public function index(Request $request): View
    {
        $query = Course::with('program');

        if ($programId = $request->integer('program_id')) {
            if ($programId > 0) {
                $query->where('program_id', $programId);
            }
        }

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%$search%")
                  ->orWhere('title', 'like', "%$search%");
            });
        }

        $courses = $query->orderBy('program_id')->orderBy('year_level')->orderBy('semester')->paginate(15)->withQueryString();
        $programs = Program::orderBy('name')->get();

        return view('admin.courses.index', compact('courses', 'programs'));
    }

    public function create(): View
    {
        $programs = Program::orderBy('name')->get();
        return view('admin.courses.create', compact('programs'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required','string','max:50','unique:courses,code'],
            'title' => ['required','string','max:255'],
            'units' => ['required','integer','min:1','max:10'],
            'program_id' => ['required','exists:programs,id'],
            'year_level' => ['required','integer','min:1','max:6'],
            'semester' => ['required','integer','min:1','max:3'],
        ]);

        Course::create($data);

        return redirect()->route('admin.courses.index')->with('status', 'Course created.');
    }

    public function edit(Course $course): View
    {
        $programs = Program::orderBy('name')->get();
        return view('admin.courses.edit', compact('course', 'programs'));
    }

    public function update(Request $request, Course $course): RedirectResponse
    {
        $data = $request->validate([
            'code' => ['required','string','max:50','unique:courses,code,'.$course->id],
            'title' => ['required','string','max:255'],
            'units' => ['required','integer','min:1','max:10'],
            'program_id' => ['required','exists:programs,id'],
            'year_level' => ['required','integer','min:1','max:6'],
            'semester' => ['required','integer','min:1','max:3'],
        ]);

        $course->update($data);

        return redirect()->route('admin.courses.index')->with('status', 'Course updated.');
    }

    public function destroy(Course $course): RedirectResponse
    {
        $course->delete();
        return redirect()->route('admin.courses.index')->with('status', 'Course removed.');
    }
}

