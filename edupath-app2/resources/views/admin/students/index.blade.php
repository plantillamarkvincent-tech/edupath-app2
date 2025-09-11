@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Students</h1>

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
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Name or student number" class="border rounded p-2 w-full" />
        </div>
        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
            <a href="{{ route('admin.students.index') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Reset</a>
        </div>
    </form>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                    <th class="p-3">Student Number</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Program</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Enrolled</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="p-3">{{ $student->student_number }}</td>
                        <td class="p-3">{{ $student->first_name }} {{ $student->last_name }}</td>
                        <td class="p-3">{{ $student->program?->name }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @if($student->status === 'active') bg-green-100 text-green-800
                                @elseif($student->status === 'inactive') bg-red-100 text-red-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($student->status) }}
                            </span>
                        </td>
                        <td class="p-3">{{ $student->created_at->format('M d, Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3" colspan="5">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $students->links() }}</div>
</div>
@endsection
