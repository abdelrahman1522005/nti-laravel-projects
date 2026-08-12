<?php

namespace Database\Seeders;

use App\Models\CandidateProfile;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin account
        User::firstOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'role' => 'admin',
            ]
        );

        // Sample candidate accounts, each with a matching profile
        $candidates = [
            [
                'name' => 'Ahmed Mostafa',
                'email' => 'ahmed@example.com',
                'full_name' => 'Ahmed Mostafa',
                'job_title' => 'Backend Developer',
                'skills' => ['PHP', 'Laravel', 'MySQL'],
                'age' => 24,
                'phone_number' => '01000000001',
            ],
            [
                'name' => 'Sara Ali',
                'email' => 'sara@example.com',
                'full_name' => 'Sara Ali',
                'job_title' => 'UI/UX Designer',
                'skills' => ['Figma', 'UI Design'],
                'age' => 23,
                'phone_number' => '01000000002',
            ],
            [
                'name' => 'Mohamed Hassan',
                'email' => 'mohamed@example.com',
                'full_name' => 'Mohamed Hassan',
                'job_title' => 'Data Analyst',
                'skills' => ['SQL', 'Power BI', 'Python'],
                'age' => 26,
                'phone_number' => '01000000003',
            ],
        ];

        foreach ($candidates as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['name'],
                    'password' => Hash::make('password'),
                    'role' => 'candidate',
                ]
            );

            CandidateProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'full_name' => $data['full_name'],
                    'job_title' => $data['job_title'],
                    'skills' => $data['skills'],
                    'age' => $data['age'],
                    'phone_number' => $data['phone_number'],
                    'description' => 'Sample profile created by the seeder.',
                ]
            );
        }
    }
}