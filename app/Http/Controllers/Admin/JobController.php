<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\JobPost;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = JobPost::withCount('applications')->latest()->paginate(15);

        return view('admin.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.jobs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['admin_id'] = $request->user()->id;

        JobPost::create($validated);

        return redirect()->route('admin.jobs.index')->with('status', 'Job created.');
    }

    public function edit(JobPost $job)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, JobPost $job)
    {
        $job->update($this->validated($request));

        return redirect()->route('admin.jobs.index')->with('status', 'Job updated.');
    }

    public function destroy(JobPost $job)
    {
        $job->delete();

        return back()->with('status', 'Job deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'required_skills' => ['nullable', 'string'], // comma-separated
            'category_id' => ['nullable', 'exists:categories,id'],
            'location' => ['nullable', 'string', 'max:255'],
            'work_type' => ['required', 'in:remote,on-site,hybrid'],
            'salary' => ['nullable', 'numeric', 'min:0'],
            'application_deadline' => ['nullable', 'date'],
        ]);

        $data['required_skills'] = collect(explode(',', $data['required_skills'] ?? ''))
            ->map(fn ($skill) => trim($skill))
            ->filter()
            ->values()
            ->all();

        return $data;
    }
}
