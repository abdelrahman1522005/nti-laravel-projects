<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Http\Request;

class ChatbotController extends Controller
{
    public function ask(Request $request)
    {
        $validated = $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        $user = $request->user();
        $message = strtolower(trim($validated['message']));

        $reply = $user->isAdmin()
            ? $this->answerAdminQuery($message)
            : $this->answerCandidateQuery($user, $message);

        return response()->json(['reply' => $reply]);
    }

    /*
    |--------------------------------------------------------------------------
    | Candidate side
    |--------------------------------------------------------------------------
    */

    private function answerCandidateQuery($user, string $message): string
    {
        $profile = $user->candidateProfile;
        $candidateSkills = collect($profile?->skills ?? [])
            ->map(fn ($s) => strtolower(trim($s)))
            ->filter()
            ->values();

        if ($candidateSkills->isEmpty()) {
            return "I don't see any skills on your profile yet. Add some skills on your Profile page "
                ."and I'll be able to match you with jobs and suggest what to learn.";
        }

        // "what skills should I learn?"
        if (str_contains($message, 'skill') && (str_contains($message, 'learn') || str_contains($message, 'should'))) {
            return $this->suggestSkillsToLearn($candidateSkills);
        }

        // "best jobs for me" / "which jobs match my skills"
        if (str_contains($message, 'best job')
            || str_contains($message, 'match')
            || str_contains($message, 'suitable')
            || str_contains($message, 'recommend')) {
            return $this->recommendJobs($candidateSkills);
        }

        return "I can help with: 'What are the best jobs for me?', 'Which jobs match my skills?', "
            ."or 'What skills should I learn?'";
    }

    private function recommendJobs($candidateSkills): string
    {
        $jobs = JobPost::query()->whereNotNull('required_skills')->get();

        $ranked = $jobs->map(function ($job) use ($candidateSkills) {
                $jobSkills = collect($job->required_skills ?? [])->map(fn ($s) => strtolower(trim($s)));
                $overlap = $jobSkills->intersect($candidateSkills)->count();

                return ['job' => $job, 'overlap' => $overlap, 'total' => $jobSkills->count()];
            })
            ->filter(fn ($r) => $r['overlap'] > 0)
            ->sortByDesc('overlap')
            ->take(5);

        if ($ranked->isEmpty()) {
            return "I couldn't find any jobs matching your current skills. Try browsing all jobs on the Jobs page, "
                ."or add more skills to your profile.";
        }

        $lines = $ranked->map(function ($r) {
            return "- {$r['job']->title} ({$r['overlap']}/{$r['total']} required skills match)";
        })->implode("\n");

        return "Here are the jobs that best match your skills:\n{$lines}";
    }

    private function suggestSkillsToLearn($candidateSkills): string
    {
        $allRequiredSkills = JobPost::query()
            ->whereNotNull('required_skills')
            ->get()
            ->flatMap(fn ($job) => collect($job->required_skills ?? [])->map(fn ($s) => strtolower(trim($s))));

        $missing = $allRequiredSkills
            ->filter(fn ($skill) => ! $candidateSkills->contains($skill))
            ->countBy()
            ->sortDesc()
            ->take(5);

        if ($missing->isEmpty()) {
            return "Your current skills already cover everything being asked for in open positions. Nice work!";
        }

        $lines = $missing->map(fn ($count, $skill) => "- ".ucfirst($skill)." (needed in {$count} open job".($count > 1 ? 's' : '').")")
            ->implode("\n");

        return "Based on the skills most requested across open jobs that you don't have yet, consider learning:\n{$lines}";
    }

    /*
    |--------------------------------------------------------------------------
    | Admin side
    |--------------------------------------------------------------------------
    */

    private function answerAdminQuery(string $message): string
    {
        if (str_contains($message, 'how many candidate') || (str_contains($message, 'candidate') && str_contains($message, 'registered'))) {
            $count = User::where('role', 'candidate')->count();

            return "There are currently {$count} registered candidate".($count === 1 ? '' : 's').".";
        }

        if (str_contains($message, 'most application')) {
            return $this->jobWithMostApplications();
        }

        if (str_contains($message, 'category')) {
            return $this->jobsInCategory($message);
        }

        if (str_contains($message, 'list') && str_contains($message, 'job')) {
            return $this->listAllJobs();
        }

        return "I can help with: 'How many candidates are registered?', 'Which job has the most applications?', "
            ."'List all available jobs', or 'Show jobs in the [category] category'.";
    }

    private function jobWithMostApplications(): string
    {
        $job = JobPost::withCount('applications')->orderByDesc('applications_count')->first();

        if (! $job || $job->applications_count === 0) {
            return "No job has received any applications yet.";
        }

        return "\"{$job->title}\" has the most applications, with {$job->applications_count} total.";
    }

    private function listAllJobs(): string
    {
        $jobs = JobPost::orderBy('title')->pluck('title');

        if ($jobs->isEmpty()) {
            return "There are no jobs posted yet.";
        }

        return "Available jobs:\n".$jobs->map(fn ($t) => "- {$t}")->implode("\n");
    }

    private function jobsInCategory(string $message): string
    {
        $categories = Category::pluck('name');

        $matched = $categories->first(fn ($name) => str_contains($message, strtolower($name)));

        if (! $matched) {
            $names = $categories->implode(', ');

            return "I couldn't tell which category you mean. Available categories: {$names}.";
        }

        $jobs = JobPost::whereHas('category', fn ($q) => $q->where('name', $matched))
            ->orderBy('title')
            ->pluck('title');

        if ($jobs->isEmpty()) {
            return "There are no jobs currently posted in the {$matched} category.";
        }

        return "Jobs in the {$matched} category:\n".$jobs->map(fn ($t) => "- {$t}")->implode("\n");
    }
}