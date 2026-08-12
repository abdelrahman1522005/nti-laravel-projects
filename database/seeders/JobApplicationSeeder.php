<?php

namespace Database\Seeders;

use App\Models\JobApplication;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobApplicationSeeder extends Seeder
{
    public function run(): void
    {
        $candidates = User::where('role', 'candidate')->get();
        $jobs = JobPost::all();

        if ($candidates->isEmpty() || $jobs->isEmpty()) {
            $this->command->warn('No candidates or jobs found — run UserSeeder and JobPostSeeder first.');
            return;
        }

        // Each candidate applies to the first 2 jobs available, just as sample data
        foreach ($candidates as $candidate) {
            foreach ($jobs->take(2) as $job) {
                JobApplication::firstOrCreate(
                    ['user_id' => $candidate->id, 'job_post_id' => $job->id],
                    ['status' => 'pending']
                );
            }
        }
    }
}