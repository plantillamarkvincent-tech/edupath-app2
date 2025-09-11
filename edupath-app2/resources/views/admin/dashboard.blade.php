@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6 space-y-6">
    <h1 class="text-2xl font-semibold">Admin Dashboard</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Total Requests</div>
            <div class="text-2xl font-bold">{{ $stats['requests_total'] }}</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Pending</div>
            <div class="text-2xl font-bold">{{ $stats['requests_pending'] }}</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">In Review</div>
            <div class="text-2xl font-bold">{{ $stats['requests_review'] }}</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Approved</div>
            <div class="text-2xl font-bold">{{ $stats['requests_approved'] }}</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Rejected</div>
            <div class="text-2xl font-bold">{{ $stats['requests_rejected'] }}</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Students</div>
            <div class="text-2xl font-bold">{{ $stats['students'] }}</div>
        </div>
        <div class="p-4 bg-white dark:bg-gray-800 rounded shadow">
            <div class="text-gray-500 text-sm">Programs</div>
            <div class="text-2xl font-bold">{{ $stats['programs'] }}</div>
        </div>
    </div>

    <div class="bg-white dark:bg-gray-800 rounded shadow">
        <div class="p-4 border-b border-gray-200 dark:border-gray-700 font-semibold">Recent Requests</div>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead>
                    <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                        <th class="p-3">Submitted</th>
                        <th class="p-3">Full Name</th>
                        <th class="p-3">Program</th>
                        <th class="p-3">Status</th>
                        <th class="p-3">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($recentRequests as $req)
                        <tr class="border-b border-gray-100 dark:border-gray-700">
                            <td class="p-3">{{ $req->created_at->diffForHumans() }}</td>
                            <td class="p-3">{{ $req->full_name }}</td>
                            <td class="p-3">{{ $req->program?->name }}</td>
                            <td class="p-3">{{ ucfirst($req->status) }}</td>
                            <td class="p-3">
                                <a href="{{ route('admin.enrollment_requests.show', $req) }}" class="text-indigo-600">View</a>
                            </td>
                        </tr>
                    @empty
                        <tr><td class="p-3" colspan="5">No requests yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection


