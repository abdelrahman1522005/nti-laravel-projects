@extends('layouts.app')
@section('title', 'All Applications')

@section('content')
<h1 class="text-xl font-semibold mb-4">All Applications</h1>

<form method="GET" class="flex gap-3 mb-4">
    <select name="status" class="rounded-md border-slate-300 shadow-sm text-sm">
        <option value="">Any Status</option>
        @foreach (['pending', 'cancelled', 'accepted', 'rejected'] as $status)
            <option value="{{ $status }}" @selected(request('status') == $status)>{{ ucfirst($status) }}</option>
        @endforeach
    </select>
    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Filter</button>
</form>

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-2">Candidate</th>
                <th class="px-4 py-2">Job</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Applied</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($applications as $application)
                <tr>
                    <td class="px-4 py-2">
                        <a href="{{ route('admin.candidates.show', $application->user) }}" class="hover:text-indigo-600">
                            {{ $application->user->candidateProfile?->full_name ?? $application->user->name }}
                        </a>
                    </td>
                    <td class="px-4 py-2">
                        <a href="{{ route('jobs.show', $application->jobPost) }}" class="hover:text-indigo-600">
                            {{ $application->jobPost->title }}
                        </a>
                    </td>
                    <td class="px-4 py-2 text-slate-500">{{ ucfirst($application->status) }}</td>
                    <td class="px-4 py-2 text-slate-500">{{ $application->created_at->format('M j, Y') }}</td>
                </tr>
            @empty
                <tr><td colspan="4" class="px-4 py-6 text-center text-slate-500">No applications yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $applications->withQueryString()->links() }}
</div>
@endsection
