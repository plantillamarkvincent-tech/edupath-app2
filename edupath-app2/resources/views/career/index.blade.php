@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
	@if (session('status'))
		<div class="bg-green-100 text-green-800 p-3 rounded mb-4">{{ session('status') }}</div>
	@endif
	<h1 class="text-2xl font-bold mb-4">Career Pathway Dashboard</h1>
	<div class="mb-6 flex items-center justify-between gap-4">
		<p>Choose a program to explore and enroll.</p>
		@auth
			@if (Auth::user()->isAdmin())
				<a href="{{ route('admin.programs.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Add Program</a>
			@endif
		@endauth
	</div>


	<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
		@foreach ($programs as $program)
			<div class="border rounded p-4 bg-white dark:bg-gray-900">
				<h2 class="text-xl font-semibold mb-2">{{ $program->name }}</h2>
				<p class="text-sm text-gray-600 dark:text-gray-300 mb-3">{{ $program->description }}</p>
				<div class="flex gap-2">
					<a href="{{ route('career.show', $program) }}" class="px-3 py-2 bg-blue-600 text-white rounded">Career Path</a>
					<a href="{{ route('enrollment.create', $program) }}" class="px-3 py-2 bg-emerald-600 text-white rounded">Enroll</a>
				</div>
			</div>
		@endforeach
	</div>
</div>
@endsection
