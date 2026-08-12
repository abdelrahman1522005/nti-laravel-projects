<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class CandidateController extends Controller
{
    public function index(Request $request)
    {
        $candidates = User::query()
            ->where('role', 'candidate')
            ->with('candidateProfile')
            ->when($request->filled('search'), function ($q) use ($request) {
                $q->whereHas('candidateProfile', function ($q) use ($request) {
                    $q->where('full_name', 'like', '%'.$request->search.'%');
                });
            })
            ->latest()
            ->paginate(15);

        return view('admin.candidates.index', compact('candidates'));
    }

    public function show(User $candidate)
    {
        abort_unless($candidate->role === 'candidate', 404);
        $candidate->load('candidateProfile', 'jobApplications.jobPost');

        return view('admin.candidates.show', compact('candidate'));
    }
}
