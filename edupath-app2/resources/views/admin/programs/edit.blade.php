@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6">
    <a href="{{ route('admin.programs.index') }}" class="text-sm text-gray-600">← Back</a>
    <h1 class="text-2xl font-semibold mb-4">Edit Program</h1>

    @if (session('status'))
        <div class="mb-4 p-3 bg-emerald-100 text-emerald-700 rounded">{{ session('status') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.programs.update', $program) }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm mb-1">Code</label>
                <input name="code" class="w-full border p-2 rounded" value="{{ old('code', $program->code) }}" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Name</label>
                <input name="name" class="w-full border p-2 rounded" value="{{ old('name', $program->name) }}" required />
            </div>
            <div>
                <label class="block text-sm mb-1">Years</label>
                <input type="number" min="1" max="6" name="years" class="w-full border p-2 rounded" value="{{ old('years', $program->years) }}" required />
            </div>
        </div>

        <div>
            <label class="block text-sm mb-1">Description</label>
            <textarea name="description" rows="3" class="w-full border p-2 rounded">{{ old('description', $program->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm mb-1">Possible Projects (Capstone/Thesis)</label>
            <textarea name="possible_projects" rows="5" class="w-full border p-2 rounded" placeholder="List ideas, one per line">{{ old('possible_projects', $program->possible_projects) }}</textarea>
        </div>

        <div>
            <label class="block text-sm mb-1">Possible Careers</label>
            <textarea name="possible_careers" rows="5" class="w-full border p-2 rounded" placeholder="List roles, one per line">{{ old('possible_careers', $program->possible_careers) }}</textarea>
        </div>

        <div class="flex gap-2">
            <button class="px-4 py-2 bg-indigo-600 text-white rounded">Save</button>
            <a href="{{ route('admin.programs.index') }}" class="px-4 py-2 bg-gray-200 rounded">Cancel</a>
        </div>
    </form>
</div>
@endsection


