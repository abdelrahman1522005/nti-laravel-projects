@extends('layouts.app')
@section('title', 'New Job')

@section('content')
<div class="max-w-2xl mx-auto bg-white border border-slate-200 rounded-lg p-6">
    <h1 class="text-lg font-semibold mb-4">New Job</h1>

    <form method="POST" action="{{ route('admin.jobs.store') }}" class="space-y-4">
        @csrf
        @include('admin.jobs._form')
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Create Job
        </button>
    </form>
</div>
@endsection
