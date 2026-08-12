<?php

namespace App\Http\Controllers;

use App\Models\JobApplication;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobApplicationController extends Controller
{
    // candidate's own list of applications
    public function index(Request $request)
    {
        $applications = $request->user()
            ->jobApplications()
            ->with('jobPost.category')
            ->latest()
            ->paginate(10);

        return view('applications.index', compact('applications'));
    }

    public function store(Request $request, JobPost $job)
    {
        if (! $job->isOpen()) {
            return back()->with('error', 'This job is no longer accepting applications.');
        }

        JobApplication::updateOrCreate(
            ['user_id' => $request->user()->id, 'job_post_id' => $job->id],
            ['status' => 'pending']
        );

        return back()->with('status', 'Application submitted.');
    }

    public function destroy(Request $request, JobApplication $application)
    {
        abort_unless($application->user_id === $request->user()->id, 403);

        $application->update(['status' => 'cancelled']);

        return back()->with('status', 'Application cancelled.');
    }
}
