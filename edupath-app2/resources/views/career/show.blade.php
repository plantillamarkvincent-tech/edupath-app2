@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
	<h1 class="text-2xl font-bold mb-4">{{ $program->name }}</h1>
	<p class="mb-4">{{ $program->description }}</p>
	<div class="flex gap-2 mb-6">
		<a href="{{ route('enrollment.create', $program) }}" class="px-3 py-2 bg-emerald-600 text-white rounded">Enroll</a>
		<a href="{{ route('career.index') }}" class="px-3 py-2 bg-gray-600 text-white rounded">Back</a>
	</div>

	<!-- Subjects by Year/Semester -->
	<div class="mb-8">
		<h2 class="text-xl font-semibold mb-3">Subjects by Year and Semester</h2>
		@php
			$grouped = $program->courses()->orderBy('year_level')->orderBy('semester')->get()->groupBy(['year_level','semester']);
		@endphp
		<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
		@foreach ($grouped as $year => $bySem)
			<div class="border rounded p-4 bg-white dark:bg-gray-900">
				<h3 class="font-semibold mb-2">Year {{ $year }}</h3>
				@foreach ($bySem as $sem => $courses)
					<div class="mb-3">
						<div class="text-sm font-medium mb-1">Semester {{ $sem }}</div>
						<ul class="list-disc ms-5 text-sm">
							@foreach ($courses as $course)
								<li>{{ $course->code }} - {{ $course->title }} ({{ $course->units }} units)</li>
							@endforeach
						</ul>
					</div>
				@endforeach
			</div>
		@endforeach
		</div>
	</div>

	<!-- Possible Projects -->
	<div class="mb-8">
		<h2 class="text-xl font-semibold mb-2">Possible Projects (Capstone/Thesis)</h2>
		<div class="prose dark:prose-invert max-w-none text-sm">
			{!! nl2br(e($program->possible_projects ?? '')) ?: 'Details coming soon.' !!}
		</div>
	</div>

	<!-- Possible Careers -->
	<div class="mb-8">
		<h2 class="text-xl font-semibold mb-2">Possible Careers</h2>
		<div class="prose dark:prose-invert max-w-none text-sm">
			{!! nl2br(e($program->possible_careers ?? '')) ?: 'Details coming soon.' !!}
		</div>
	</div>
</div>
@endsection
