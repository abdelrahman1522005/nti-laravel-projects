@extends('layouts.app')
@section('title', 'Browse Jobs')

@section('content')
<h1 class="text-xl font-semibold mb-4">Browse Jobs</h1>

<form method="GET" class="flex flex-wrap gap-3 mb-6 bg-white border border-slate-200 rounded-lg p-4">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by title"
           class="flex-1 min-w-[180px] rounded-md border-slate-300 shadow-sm text-sm">

    <select name="category" class="rounded-md border-slate-300 shadow-sm text-sm">
        <option value="">All Categories</option>
        @foreach ($categories as $category)
            <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
        @endforeach
    </select>

    <select name="work_type" class="rounded-md border-slate-300 shadow-sm text-sm">
        <option value="">Any Work Type</option>
        @foreach (['remote' => 'Remote', 'on-site' => 'On-site', 'hybrid' => 'Hybrid'] as $value => $label)
            <option value="{{ $value }}" @selected(request('work_type') == $value)>{{ $label }}</option>
        @endforeach
    </select>

    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md text-sm hover:bg-indigo-700">Filter</button>
</form>

<div class="space-y-3">
    @forelse ($jobs as $job)
        <a href="{{ route('jobs.show', $job) }}" class="block bg-white border border-slate-200 rounded-lg p-4 hover:border-indigo-300">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="font-medium">{{ $job->title }}</h2>
                    <p class="text-sm text-slate-500">
                        {{ $job->category?->name ?? 'Uncategorized' }}
                        @if ($job->location) &middot; {{ $job->location }} @endif
                        &middot; {{ ucfirst($job->work_type) }}
                    </p>
                </div>
                @if ($job->salary)
                    <span class="text-sm text-slate-600 whitespace-nowrap">${{ number_format($job->salary) }}</span>
                @endif
            </div>
        </a>
    @empty
        <p class="text-slate-500">No jobs match your filters.</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $jobs->withQueryString()->links() }}
</div>
@endsection
