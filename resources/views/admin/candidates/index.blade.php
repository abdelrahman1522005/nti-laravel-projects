@extends('layouts.app')
@section('title', 'Candidates')

@section('content')
<h1 class="text-xl font-semibold mb-4">Candidates</h1>

<form method="GET" class="mb-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name"
           class="w-full max-w-sm rounded-md border-slate-300 shadow-sm text-sm">
</form>

<div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-slate-50 text-left text-slate-500">
            <tr>
                <th class="px-4 py-2">Name</th>
                <th class="px-4 py-2">Email</th>
                <th class="px-4 py-2">Job Title</th>
                <th class="px-4 py-2">Skills</th>
                <th class="px-4 py-2"></th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100">
            @forelse ($candidates as $candidate)
                <tr>
                    <td class="px-4 py-2">{{ $candidate->candidateProfile?->full_name ?? $candidate->name }}</td>
                    <td class="px-4 py-2 text-slate-500">{{ $candidate->email }}</td>
                    <td class="px-4 py-2 text-slate-500">{{ $candidate->candidateProfile?->job_title ?? '—' }}</td>
                    <td class="px-4 py-2 text-slate-500">
                        {{ $candidate->candidateProfile?->skills ? implode(', ', $candidate->candidateProfile->skills) : '—' }}
                    </td>
                    <td class="px-4 py-2 text-right">
                        <a href="{{ route('admin.candidates.show', $candidate) }}" class="text-indigo-600 hover:underline">View</a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="px-4 py-6 text-center text-slate-500">No candidates yet.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-6">
    {{ $candidates->withQueryString()->links() }}
</div>
@endsection
