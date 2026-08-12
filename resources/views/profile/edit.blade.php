@extends('layouts.app')
@section('title', 'My Profile')

@section('content')
<div class="max-w-2xl mx-auto bg-white border border-slate-200 rounded-lg p-6">
    <h1 class="text-lg font-semibold mb-4">My Profile</h1>

    <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Full Name</label>
            <input type="text" name="full_name" value="{{ old('full_name', $profile->full_name) }}" required
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Age</label>
                <input type="number" name="age" value="{{ old('age', $profile->age) }}"
                       class="w-full rounded-md border-slate-300 shadow-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Job Title</label>
                <input type="text" name="job_title" value="{{ old('job_title', $profile->job_title) }}"
                       class="w-full rounded-md border-slate-300 shadow-sm">
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Profile Description</label>
            <textarea name="description" rows="4"
                      class="w-full rounded-md border-slate-300 shadow-sm">{{ old('description', $profile->description) }}</textarea>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Phone Number</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $profile->phone_number) }}"
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Skills (comma-separated)</label>
            <input type="text" name="skills" placeholder="PHP, Laravel, MySQL"
                   value="{{ old('skills', $profile->skills ? implode(', ', $profile->skills) : '') }}"
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Profile Image</label>
                @if ($profile->profile_image)
                    <img src="{{ Storage::url($profile->profile_image) }}" class="w-16 h-16 rounded-full object-cover mb-2">
                @endif
                <input type="file" name="profile_image" accept="image/*" class="w-full text-sm">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Resume (CV)</label>
                @if ($profile->resume)
                    <a href="{{ Storage::url($profile->resume) }}" class="text-indigo-600 text-sm block mb-2" target="_blank">Current resume</a>
                @endif
                <input type="file" name="resume" accept=".pdf,.doc,.docx" class="w-full text-sm">
            </div>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700">
            Save Profile
        </button>
    </form>
</div>
@endsection
