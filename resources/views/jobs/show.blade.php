@extends('layouts.app')
@section('title', $job->title)

@section('content')
<div class="bg-white border border-slate-200 rounded-lg p-6">
    <div class="flex items-start justify-between mb-4">
        <div>
            <h1 class="text-xl font-semibold">{{ $job->title }}</h1>
            <p class="text-sm text-slate-500 mt-1">
                {{ $job->category?->name ?? 'Uncategorized' }}
                @if ($job->location) &middot; {{ $job->location }} @endif
                &middot; {{ ucfirst($job->work_type) }}
            </p>
        </div>
        @if ($job->salary)
            <span class="text-slate-700 font-medium">${{ number_format($job->salary) }}</span>
        @endif
    </div>

    @if ($job->application_deadline)
        <p class="text-sm text-slate-500 mb-4">Apply by {{ $job->application_deadline->format('M j, Y') }}</p>
    @endif

    <div class="prose prose-sm max-w-none text-slate-700 mb-4">
        {{ $job->description }}
    </div>

    @if ($job->required_skills)
        <div class="flex flex-wrap gap-2 mb-6">
            @foreach ($job->required_skills as $skill)
                <span class="text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded-full">{{ $skill }}</span>
            @endforeach
        </div>
    @endif

    @auth
        @if (! auth()->user()->isAdmin())
            @if ($hasApplied)
                <span class="inline-block bg-green-50 text-green-700 border border-green-200 px-4 py-2 rounded-md text-sm">
                    You've applied to this job.
                </span>
            @elseif ($job->isOpen())
                <form method="POST" action="{{ route('applications.store', $job) }}">
                    @csrf
                    <button class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
                        Apply Now
                    </button>
                </form>
            @else
                <span class="inline-block bg-slate-100 text-slate-500 px-4 py-2 rounded-md text-sm">
                    Applications closed
                </span>
            @endif
        @endif
    @else
        <a href="{{ route('login') }}" class="text-indigo-600 text-sm">Login to apply</a>
    @endauth
</div>
@endsection
