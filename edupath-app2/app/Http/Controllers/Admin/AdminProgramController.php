<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminProgramController extends Controller
{
    public function index(): View
    {
        $programs = Program::orderBy('name')->paginate(15);
        return view('admin.programs.index', compact('programs'));
    }

    public function create(): View
    {
        return view('admin.programs.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['required','string','max:50','unique:programs,code'],
            'description' => ['nullable','string'],
            'years' => ['required','integer','min:1','max:6'],
            'possible_projects' => ['nullable','string'],
            'possible_careers' => ['nullable','string'],
        ]);

        Program::create($data);

        return redirect()->route('admin.programs.index')->with('status', 'Program created.');
    }

    public function edit(Program $program): View
    {
        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program): RedirectResponse
    {
        $data = $request->validate([
            'name' => ['required','string','max:255'],
            'code' => ['required','string','max:50'],
            'description' => ['nullable','string'],
            'years' => ['required','integer','min:1','max:6'],
            'possible_projects' => ['nullable','string'],
            'possible_careers' => ['nullable','string'],
        ]);

        $program->update($data);

        return redirect()->route('admin.programs.edit', $program)->with('status', 'Program updated.');
    }

    public function destroy(Program $program): RedirectResponse
    {
        $program->delete();
        return redirect()->route('admin.programs.index')->with('status', 'Program removed.');
    }
}


