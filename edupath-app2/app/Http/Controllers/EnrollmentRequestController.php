<?php

namespace App\Http\Controllers;

use App\Models\Program;
use App\Models\EnrollmentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnrollmentRequestController extends Controller
{
	public function create(Program $program)
	{
		return view('enrollment.create', compact('program'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'program_id' => ['required','exists:programs,id'],
			'full_name' => ['required','string','max:255'],
			'email' => ['required','email','max:255'],
			'contact_number' => ['nullable','string','max:100'],
			'address' => ['nullable','string','max:255'],
			'last_school_attended' => ['nullable','string','max:255'],
			'school_year' => ['nullable','string','max:50'],
		]);

		$validated['user_id'] = Auth::id();

		$enrollment = EnrollmentRequest::create($validated);

		return redirect()->route('career.index')->with('status', 'Enrollment request submitted.');
	}
}
