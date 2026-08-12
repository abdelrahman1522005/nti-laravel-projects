@extends('layouts.app')
@section('title', 'My Applications')

@section('content')
<h1 class="text-xl font-semibold mb-4">My Applications</h1>

<div class="space-y-3">
    @forelse ($applications as $application)
        <div class="bg-white border border-slate-200 rounded-lg p-4 flex items-center justify-between">
            <div>
                <a href="{{ route('jobs.show', $application->jobPost) }}" class="font-medium hover:text-indigo-600">
                    {{ $application->jobPost->title }}
                </a>
                <p class="text-sm text-slate-500">
                    {{ $application->jobPost->category?->name ?? 'Uncategorized' }}
                    &middot; Applied {{ $application->created_at->diffForHumans() }}
                </p>
            </div>

            <div class="flex items-center gap-3">
                <span @class([
                    'text-xs px-2 py-1 rounded-full',
                    'bg-yellow-50 text-yellow-700' => $application->status === 'pending',
                    'bg-slate-100 text-slate-500' => $application->status === 'cancelled',
                    'bg-green-50 text-green-700' => $application->status === 'accepted',
                    'bg-red-50 text-red-700' => $application->status === 'rejected',
                ])>
                    {{ ucfirst($application->status) }}
                </span>

                @if ($application->status === 'pending')
                    <form method="POST" action="{{ route('applications.destroy', $application) }}">
                        @csrf
                        @method('DELETE')
                        <button class="text-sm text-red-600 hover:underline">Cancel</button>
                    </form>
                @endif
            </div>
        </div>
    @empty
        <p class="text-slate-500">You haven't applied to any jobs yet.</p>
    @endforelse
</div>

<div class="mt-6">
    {{ $applications->links() }}
</div>
@endsection
