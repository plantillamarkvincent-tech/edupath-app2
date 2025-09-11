@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-6">Student Dashboard</h1>

    @if($student)
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
            <strong>Welcome!</strong> You are enrolled as a student.
            <div class="text-sm mt-1">
                Student Number: {{ $student->student_number }} | 
                Program: {{ $student->program?->name ?? 'Not assigned' }} | 
                Status: {{ ucfirst($student->status) }}
            </div>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Enrollment Requests -->
        <div class="bg-white dark:bg-gray-800 rounded shadow">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold">My Enrollment Requests</h2>
            </div>
            <div class="p-4">
                @forelse($enrollmentRequests as $request)
                    <div class="border border-gray-200 dark:border-gray-700 rounded p-3 mb-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <div class="font-medium">{{ $request->program?->name }}</div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">
                                    Submitted: {{ $request->created_at->format('M d, Y') }}
                                </div>
                            </div>
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @if($request->status === 'approved') bg-green-100 text-green-800
                                @elseif($request->status === 'rejected') bg-red-100 text-red-800
                                @elseif($request->status === 'review') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($request->status) }}
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="text-gray-500 text-center py-4">
                        No enrollment requests found.
                        <a href="{{ route('career.index') }}" class="text-indigo-600 hover:underline">Browse programs</a>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white dark:bg-gray-800 rounded shadow">
            <div class="p-4 border-b border-gray-200 dark:border-gray-700">
                <h2 class="text-lg font-semibold">Quick Actions</h2>
            </div>
            <div class="p-4 space-y-3">
                <a href="{{ route('career.index') }}" 
                   class="block w-full bg-indigo-600 text-white text-center py-2 px-4 rounded hover:bg-indigo-700 transition">
                    Browse Programs
                </a>
                <a href="{{ route('profile.edit') }}" 
                   class="block w-full bg-gray-600 text-white text-center py-2 px-4 rounded hover:bg-gray-700 transition">
                    Edit Profile
                </a>
                @if($student)
                    <a href="#" 
                       class="block w-full bg-green-600 text-white text-center py-2 px-4 rounded hover:bg-green-700 transition">
                        View My Courses
                    </a>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
