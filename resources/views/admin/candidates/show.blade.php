@extends('layouts.app')
@section('title', 'Candidate Profile')

@section('content')
@php $profile = $candidate->candidateProfile; @endphp

<div class="bg-white border border-slate-200 rounded-lg p-6 mb-6">
    <div class="flex items-center gap-4 mb-4">
        @if ($profile?->profile_image)
            <img src="{{ Storage::url($profile->profile_image) }}" class="w-16 h-16 rounded-full object-cover">
        @endif
        <div>
            <h1 class="text-lg font-semibold">{{ $profile?->full_name ?? $candidate->name }}</h1>
            <p class="text-sm text-slate-500">{{ $candidate->email }} @if ($profile?->phone_number) &middot; {{ $profile->phone_number }} @endif</p>
        </div>
    </div>

    @if ($profile?->job_title)
        <p class="text-sm text-slate-600 mb-2"><strong>Title:</strong> {{ $profile->job_title }}</p>
    @endif

    @if ($profile?->description)
        <p class="text-sm text-slate-700 mb-4">{{ $profile->description }}</p>
    @endif

    @if ($profile?->skills)
        <div class="flex flex-wrap gap-2 mb-4">
            @foreach ($profile->skills as $skill)
                <span class="text-xs bg-slate-100 text-slate-700 px-2 py-1 rounded-full">{{ $skill }}</span>
            @endforeach
        </div>
    @endif

    @if ($profile?->resume)
        <a href="{{ Storage::url($profile->resume) }}" class="text-indigo-600 text-sm" target="_blank">View Resume</a>
    @endif
</div>

<h2 class="font-medium mb-3">Applications</h2>
<div class="space-y-2">
    @forelse ($candidate->jobApplications as $application)
        <div class="bg-white border border-slate-200 rounded-lg p-3 flex items-center justify-between text-sm">
            <a href="{{ route('jobs.show', $application->jobPost) }}" class="hover:text-indigo-600">
                {{ $application->jobPost->title }}
            </a>
            <span class="text-xs text-slate-500">{{ ucfirst($application->status) }}</span>
        </div>
    @empty
        <p class="text-slate-500 text-sm">No applications yet.</p>
    @endforelse
</div>
@endsection
