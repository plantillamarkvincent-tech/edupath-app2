@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Courses</h1>
        <a href="{{ route('admin.courses.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Add Course</a>
    </div>

    <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end">
        <div>
            <label class="block text-sm mb-1">Program</label>
            <select name="program_id" class="border rounded p-2">
                <option value="">All</option>
                @foreach ($programs as $p)
                    <option value="{{ $p->id }}" @selected((string)request('program_id')===(string)$p->id)>{{ $p->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="flex-1 min-w-[200px]">
            <label class="block text-sm mb-1">Search</label>
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Course code or title" class="border rounded p-2 w-full" />
        </div>
        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
            <a href="{{ route('admin.courses.index') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Reset</a>
        </div>
    </form>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                    <th class="p-3">Code</th>
                    <th class="p-3">Title</th>
                    <th class="p-3">Units</th>
                    <th class="p-3">Program</th>
                    <th class="p-3">Year</th>
                    <th class="p-3">Sem</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($courses as $course)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="p-3">{{ $course->code }}</td>
                        <td class="p-3">{{ $course->title }}</td>
                        <td class="p-3">{{ $course->units }}</td>
                        <td class="p-3">{{ $course->program?->name }}</td>
                        <td class="p-3">{{ $course->year_level }}</td>
                        <td class="p-3">{{ $course->semester }}</td>
                        <td class="p-3 flex items-center gap-3">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="text-indigo-600">Edit</a>
                            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}" onsubmit="return confirm('Remove this course?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3" colspan="7">No courses found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $courses->links() }}</div>
</div>
@endsection

