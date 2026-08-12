<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobController extends Controller
{
    // browse available jobs, filterable by category/work type/search term
    public function index(Request $request)
    {
        $jobs = JobPost::query()
            ->with('category')
            ->when($request->filled('category'), fn ($q) => $q->where('category_id', $request->category))
            ->when($request->filled('work_type'), fn ($q) => $q->where('work_type', $request->work_type))
            ->when($request->filled('search'), fn ($q) => $q->where('title', 'like', '%'.$request->search.'%'))
            ->latest()
            ->paginate(12);

        $categories = Category::orderBy('name')->get();

        return view('jobs.index', compact('jobs', 'categories'));
    }

    public function show(JobPost $job)
    {
        $job->load('category');

        $hasApplied = auth()->check()
            ? $job->applications()->where('user_id', auth()->id())->where('status', '!=', 'cancelled')->exists()
            : false;

        return view('jobs.show', compact('job', 'hasApplied'));
    }
}
