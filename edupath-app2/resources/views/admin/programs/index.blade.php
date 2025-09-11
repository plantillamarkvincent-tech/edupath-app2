@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-semibold">Programs</h1>
        <a href="{{ route('admin.programs.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded">Add Program</a>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-800 rounded shadow">
        <table class="min-w-full text-sm">
            <thead>
                <tr class="text-left border-b border-gray-200 dark:border-gray-700">
                    <th class="p-3">Code</th>
                    <th class="p-3">Name</th>
                    <th class="p-3">Years</th>
                    <th class="p-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                    <tr class="border-b border-gray-100 dark:border-gray-700">
                        <td class="p-3">{{ $program->code }}</td>
                        <td class="p-3">{{ $program->name }}</td>
                        <td class="p-3">{{ $program->years }}</td>
                        <td class="p-3 flex items-center gap-3">
                            <a href="{{ route('admin.programs.edit', $program) }}" class="text-indigo-600">Edit</a>
                            <form method="POST" action="{{ route('admin.programs.destroy', $program) }}" onsubmit="return confirm('Remove this program?');">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-600">Remove</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $programs->links() }}</div>
</div>
@endsection


