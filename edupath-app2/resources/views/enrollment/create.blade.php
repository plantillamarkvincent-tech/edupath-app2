@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
	<h1 class="text-2xl font-bold mb-4">Enroll in {{ $program->name }}</h1>
	<form method="POST" action="{{ route('enrollment.store') }}" class="space-y-4">
		@csrf
		<input type="hidden" name="program_id" value="{{ $program->id }}" />
		<div>
			<label class="block mb-1">Full Name</label>
			<input name="full_name" class="w-full border p-2 rounded" required />
		</div>
		<div>
			<label class="block mb-1">Email</label>
			<input type="email" name="email" class="w-full border p-2 rounded" required />
		</div>
		<div>
			<label class="block mb-1">Contact Number</label>
			<input name="contact_number" class="w-full border p-2 rounded" />
		</div>
		<div>
			<label class="block mb-1">Address</label>
			<input name="address" class="w-full border p-2 rounded" />
		</div>
		<div>
			<label class="block mb-1">Last School Attended</label>
			<input name="last_school_attended" class="w-full border p-2 rounded" />
		</div>
		<div>
			<label class="block mb-1">School Year</label>
			<input name="school_year" placeholder="2025-2026" class="w-full border p-2 rounded" />
		</div>
		<div class="flex gap-2">
			<button class="px-4 py-2 bg-emerald-600 text-white rounded" type="submit">Enroll</button>
			<a href="{{ route('career.index') }}" class="px-4 py-2 bg-gray-600 text-white rounded">Cancel</a>
		</div>
	</form>
</div>
@endsection
