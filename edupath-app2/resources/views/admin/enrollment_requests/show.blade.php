@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto p-6">
    <a href="{{ route('admin.enrollment_requests.index') }}" class="text-sm text-gray-600">← Back</a>
    <h1 class="text-2xl font-semibold mb-4">Enrollment Request</h1>

    @if (session('status'))
        <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded">{{ session('status') }}</div>
    @endif

    <div class="bg-white dark:bg-gray-800 rounded shadow p-4 space-y-2">
        <div><strong>Submitted:</strong> {{ $enrollmentRequest->created_at->toDayDateTimeString() }}</div>
        <div><strong>Status:</strong> {{ ucfirst($enrollmentRequest->status) }}</div>
        <div><strong>Program:</strong> {{ $enrollmentRequest->program?->name }}</div>
        <div><strong>Full name:</strong> {{ $enrollmentRequest->full_name }}</div>
        <div><strong>Email:</strong> {{ $enrollmentRequest->email }}</div>
        <div><strong>Contact number:</strong> {{ $enrollmentRequest->contact_number }}</div>
        <div><strong>Address:</strong> {{ $enrollmentRequest->address }}</div>
        <div><strong>Last school attended:</strong> {{ $enrollmentRequest->last_school_attended }}</div>
        <div><strong>School year:</strong> {{ $enrollmentRequest->school_year }}</div>
    </div>

    <div class="mt-4 flex gap-2">
        <form method="POST" action="{{ route('admin.enrollment_requests.approve', $enrollmentRequest) }}">
            @csrf
            <button class="px-4 py-2 bg-emerald-600 text-white rounded" @disabled($enrollmentRequest->status === 'approved')>Approve</button>
        </form>
        <form method="POST" action="{{ route('admin.enrollment_requests.reject', $enrollmentRequest) }}" class="flex items-center gap-2">
            @csrf
            <input type="text" name="admin_note" placeholder="Reason (optional)" class="border rounded p-2" />
            <button class="px-4 py-2 bg-rose-600 text-white rounded" @disabled($enrollmentRequest->status === 'rejected')>Reject</button>
        </form>
    </div>
</div>
@endsection


