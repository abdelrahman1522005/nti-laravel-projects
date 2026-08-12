<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\JobApplication;
use Illuminate\Http\Request;

class ApplicationController extends Controller
{
    public function index(Request $request)
    {
        $applications = JobApplication::query()
            ->with(['user.candidateProfile', 'jobPost'])
            ->when($request->filled('job_post_id'), fn ($q) => $q->where('job_post_id', $request->job_post_id))
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->latest()
            ->paginate(20);

        return view('admin.applications.index', compact('applications'));
    }
}
