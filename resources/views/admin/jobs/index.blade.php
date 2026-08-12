@extends('layouts.app')
@section('title', 'Manage Jobs')

@section('content')
<div class="flex items-center justify-between mb-4">
    <h1 class="text-xl font-semibold">Manage Jobs</h1>
    <a href="{{ route('admin.jobs.create') }}" class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">
        + New Job
    </a>
</div>

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-2">Title</th>
                <th class="px-4 py-2">Category</th>
                <th class="px-4 py-2">Applications</th>
                <th class="px-4 py-2">Deadline</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($jobs as $job)
                <tr>
                    <td class="px-4 py-2">
                        <a href="{{ route('jobs.show', $job) }}" class="hover:text-indigo-600">{{ $job->title }}</a>
                    </td>
                    <td class="px-4 py-2 text-slate-500">{{ $job->category?->name ?? '—' }}</td>
                    <td class="px-4 py-2 text-slate-500">{{ $job->applications_count }}</td>
                    <td class="px-4 py-2 text-slate-500">{{ $job->application_deadline?->format('M j, Y') ?? '—' }}</td>
                    <td class="px-4 py-2 text-right space-x-3">
                        <a href="{{ route('admin.jobs.edit', $job) }}" class="text-indigo-600 hover:underline">Edit</a>
                        <form method="POST" action="{{ route('admin.jobs.destroy', $job) }}" class="inline"
                              onsubmit="return confirm('Delete this job?');">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-600 hover:underline">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-slate-500">No jobs yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $jobs->links() }}
</div>
@endsection
