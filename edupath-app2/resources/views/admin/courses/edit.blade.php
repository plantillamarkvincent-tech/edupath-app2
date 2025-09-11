@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <a href="{{ route('admin.courses.index') }}" class="text-sm text-gray-600">← Back</a>
    <h1 class="text-2xl font-semibold mb-4">Edit Course</h1>

    @if (session('status'))
        <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Course Code</label>
                <input name="code" class="w-full border p-2 rounded" value="{{ old('code', $course->code) }}" required />
                @error('code')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Course Title</label>
                <input name="title" class="w-full border p-2 rounded" value="{{ old('title', $course->title) }}" required />
                @error('title')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Units</label>
                <input type="number" min="1" max="10" name="units" class="w-full border p-2 rounded" value="{{ old('units', $course->units) }}" required />
                @error('units')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Program</label>
                <select name="program_id" class="w-full border p-2 rounded" required>
                    <option value="">Select Program</option>
                    @foreach ($programs as $program)
                        <option value="{{ $program->id }}" @selected(old('program_id', $course->program_id) == $program->id)>{{ $program->name }}</option>
                    @endforeach
                </select>
                @error('program_id')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Year Level</label>
                <select name="year_level" class="w-full border p-2 rounded" required>
                    <option value="">Select Year</option>
                    @for ($i = 1; $i <= 6; $i++)
                        <option value="{{ $i }}" @selected(old('year_level', $course->year_level) == $i)>{{ $i }}</option>
                    @endfor
                </select>
                @error('year_level')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
            <div>
                <label class="block text-sm mb-1">Semester</label>
                <select name="semester" class="w-full border p-2 rounded" required>
                    <option value="">Select Semester</option>
                    <option value="1" @selected(old('semester', $course->semester) == 1)>1st Semester</option>
                    <option value="2" @selected(old('semester', $course->semester) == 2)>2nd Semester</option>
                    <option value="3" @selected(old('semester', $course->semester) == 3)>Summer</option>
                </select>
                @error('semester')
                    <div class="text-red-500 text-sm mt-1">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Update Course</button>
            <a href="{{ route('admin.courses.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection

