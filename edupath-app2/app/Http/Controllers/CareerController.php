<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class CareerController extends Controller
{
	public function landing()
	{
		return redirect()->route('career.index');
	}

	public function index()
	{
		$programs = Program::where('name', '!=', 'BS in Secondary Education - English')
			->orderBy('name')
			->get();
		return view('career.index', compact('programs'));
	}

	public function show(Program $program)
	{
		return view('career.show', compact('program'));
	}
}
