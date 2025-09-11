@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <h1 class="text-2xl font-semibold mb-4">Enrollment Requests</h1>

    @if (session('status'))
        <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded">{{ session('status') }}</div>
    @endif

    <form method="GET" class="mb-4 flex flex-wrap gap-2 items-end">
        <div>
            <label class="block text-sm mb-1">Status</label>
            <select name="status" class="border rounded p-2">
                <option value="">All</option>
                @foreach (['pending','review','approved','rejected'] as $s)
                    <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
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
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Name or email" class="border rounded p-2 w-full" />
        </div>
        <div>
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Filter</button>
            <a href="{{ route('admin.enrollment_requests.index') }}" class="ml-2 px-4 py-2 bg-gray-200 rounded">Reset</a>
        </div>
    </form>

    <form method="POST" action="{{ route('admin.enrollment_requests.bulk_action') }}" class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        @csrf
        <div class="p-3 flex items-center gap-2 border-b border-gray-200 dark:border-gray-700">
            <select name="action" class="border rounded p-2">
                <option value="approve">Approve selected</option>
                <option value="reject">Reject selected</option>
            </select>
            <input type="text" name="admin_note" placeholder="Reason (optional for reject)" class="border rounded p-2" />
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Apply</button>
        </div>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                    <th class="p-3"><input type="checkbox" onclick="document.querySelectorAll('.req-checkbox').forEach(cb=>cb.checked=this.checked)" /></th>
                    <th class="p-3">Submitted</th>
                    <th class="p-3">Full Name</th>
                    <th class="p-3">Program</th>
                    <th class="p-3">Status</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $req)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="p-3"><input type="checkbox" class="req-checkbox" name="selected_requests[]" value="{{ $req->id }}" /></td>
                        <td class="p-3">{{ $req->created_at->diffForHumans() }}</td>
                        <td class="p-3">{{ $req->full_name }}</td>
                        <td class="p-3">{{ $req->program?->name }}</td>
                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs font-medium
                                @if($req->status === 'approved') bg-green-100 text-green-800
                                @elseif($req->status === 'rejected') bg-red-100 text-red-800
                                @elseif($req->status === 'review') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                {{ ucfirst($req->status) }}
                            </span>
                        </td>
                        <td class="p-3">
                            <a href="{{ route('admin.enrollment_requests.show', $req) }}" class="text-indigo-600">View</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td class="p-3" colspan="5">No requests yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </form>

    <div class="mt-4 flex items-center justify-between">
        <a href="{{ route('admin.enrollment_requests.index', array_merge(request()->query(), ['export' => 'csv'])) }}" class="px-4 py-2 bg-gray-200 rounded">Export CSV</a>
        <div>{{ $requests->links() }}</div>
    </div>
</div>
@endsection


