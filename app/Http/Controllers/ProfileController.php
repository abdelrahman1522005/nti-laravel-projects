<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $profile = $request->user()->candidateProfile;

        return view('profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'age' => ['nullable', 'integer', 'min:16', 'max:100'],
            'job_title' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'phone_number' => ['nullable', 'string', 'max:30'],
            'skills' => ['nullable', 'string'], // comma-separated input from the form
            'profile_image' => ['nullable', 'image', 'max:2048'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ]);

        $profile = $request->user()->candidateProfile;

        $skills = collect(explode(',', $validated['skills'] ?? ''))
            ->map(fn ($skill) => trim($skill))
            ->filter()
            ->values()
            ->all();

        $data = [
            'full_name' => $validated['full_name'],
            'age' => $validated['age'] ?? null,
            'job_title' => $validated['job_title'] ?? null,
            'description' => $validated['description'] ?? null,
            'phone_number' => $validated['phone_number'] ?? null,
            'skills' => $skills,
        ];

        if ($request->hasFile('profile_image')) {
            if ($profile->profile_image) {
                Storage::disk('public')->delete($profile->profile_image);
            }
            $data['profile_image'] = $request->file('profile_image')->store('profile-images', 'public');
        }

        if ($request->hasFile('resume')) {
            if ($profile->resume) {
                Storage::disk('public')->delete($profile->resume);
            }
            $data['resume'] = $request->file('resume')->store('resumes', 'public');
        }

        $profile->update($data);

        return redirect()->route('profile.edit')->with('status', 'Profile updated.');
    }
}
