@extends('layouts.app')
@section('title', 'Edit Job')

@section('content')
<div class="max-w-2xl mx-auto bg-white border border-slate-200 rounded-lg p-6">
    <h1 class="text-lg font-semibold mb-4">Edit Job</h1>

    <form method="POST" action="{{ route('admin.jobs.update', $job) }}" class="space-y-4">
        @csrf
        @method('PUT')
        @include('admin.jobs._form')
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Save Changes
        </button>
    </form>
</div>
@endsection
