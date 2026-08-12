<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\JobPost;
use App\Models\User;
use Illuminate\Database\Seeder;

class JobPostSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('role', 'admin')->first();

        if (! $admin) {
            $this->command->warn('No admin found — run UserSeeder first.');
            return;
        }

        $jobs = [
            [
                'title' => 'Backend Developer (Laravel)',
                'description' => 'Build and maintain REST APIs, work with MySQL, and collaborate with the frontend team.',
                'required_skills' => ['PHP', 'Laravel', 'MySQL'],
                'category' => 'Programming',
                'location' => 'Cairo, Egypt',
                'work_type' => 'remote',
                'salary' => 15000,
                'application_deadline' => now()->addDays(30),
            ],
            [
                'title' => 'UI/UX Designer',
                'description' => 'Design clean, modern interfaces for our web and mobile products.',
                'required_skills' => ['Figma', 'UI Design', 'Prototyping'],
                'category' => 'Design',
                'location' => 'Giza, Egypt',
                'work_type' => 'hybrid',
                'salary' => 12000,
                'application_deadline' => now()->addDays(20),
            ],
            [
                'title' => 'Digital Marketing Specialist',
                'description' => 'Run paid campaigns, manage social media, and analyze performance metrics.',
                'required_skills' => ['SEO', 'Google Ads', 'Content Marketing'],
                'category' => 'Marketing',
                'location' => 'Alexandria, Egypt',
                'work_type' => 'on-site',
                'salary' => 9000,
                'application_deadline' => now()->addDays(15),
            ],
            [
                'title' => 'Customer Support Agent',
                'description' => 'Handle customer inquiries via chat and email, and escalate issues when needed.',
                'required_skills' => ['Communication', 'Zendesk'],
                'category' => 'Customer Support',
                'location' => 'Remote',
                'work_type' => 'remote',
                'salary' => 7000,
                'application_deadline' => now()->addDays(25),
            ],
            [
                'title' => 'Data Analyst',
                'description' => 'Analyze business data and build dashboards to support decision making.',
                'required_skills' => ['SQL', 'Power BI', 'Python', 'Excel'],
                'category' => 'Data & Analytics',
                'location' => 'Cairo, Egypt',
                'work_type' => 'hybrid',
                'salary' => 13000,
                'application_deadline' => now()->addDays(40),
            ],
            [
                'title' => 'Backend Developer (Laravel)',
                'description' => 'Build and maintain REST APIs, work with MySQL, and collaborate with the frontend team.',
                'required_skills' => ['PHP', 'Laravel', 'MySQL'],
                'category' => 'Programming',
                'location' => 'Cairo, Egypt',
                'work_type' => 'remote',
                'salary' => 15000,
                'application_deadline' => now()->addDays(30),
            ],
            [
                'title' => 'Frontend Developer (React)',
                'description' => 'Build responsive, accessible interfaces using React and Tailwind CSS.',
                'required_skills' => ['React', 'JavaScript', 'Tailwind CSS'],
                'category' => 'Programming',
                'location' => 'Cairo, Egypt',
                'work_type' => 'on-site',
                'salary' => 14000,
                'application_deadline' => now()->addDays(35),
            ],
             [
                'title' => 'Mobile Developer (Flutter)',
                'description' => 'Develop cross-platform mobile apps for iOS and Android using Flutter.',
                'required_skills' => ['Flutter', 'Dart', 'REST API'],
                'category' => 'Programming',
                'location' => 'Cairo, Egypt',
                'work_type' => 'hybrid',
                'salary' => 16000,
                'application_deadline' => now()->addDays(28),
            ],
            [
                'title' => 'UI/UX Designer',
                'description' => 'Design clean, modern interfaces for our web and mobile products.',
                'required_skills' => ['Figma', 'UI Design', 'Prototyping'],
                'category' => 'Design',
                'location' => 'Giza, Egypt',
                'work_type' => 'hybrid',
                'salary' => 12000,
                'application_deadline' => now()->addDays(20),
            ],
                        [
                'title' => 'Graphic Designer',
                'description' => 'Create branding assets, social media graphics, and marketing materials.',
                'required_skills' => ['Photoshop', 'Illustrator', 'Branding'],
                'category' => 'Design',
                'location' => 'Alexandria, Egypt',
                'work_type' => 'on-site',
                'salary' => 8000,
                'application_deadline' => now()->addDays(18),
            ],
            [
                'title' => 'Product Designer',
                'description' => 'Own the end-to-end design process from research to high-fidelity prototypes.',
                'required_skills' => ['Figma', 'User Research', 'Design Systems'],
                'category' => 'Design',
                'location' => 'Remote',
                'work_type' => 'remote',
                'salary' => 13000,
                'application_deadline' => now()->addDays(22),
            ],
            [
                'title' => 'Digital Marketing Specialist',
                'description' => 'Run paid campaigns, manage social media, and analyze performance metrics.',
                'required_skills' => ['SEO', 'Google Ads', 'Content Marketing'],
                'category' => 'Marketing',
                'location' => 'Alexandria, Egypt',
                'work_type' => 'on-site',
                'salary' => 9000,
                'application_deadline' => now()->addDays(15),
            ],
            [
                'title' => 'Social Media Manager',
                'description' => 'Plan and execute content calendars across all social media platforms.',
                'required_skills' => ['Content Creation', 'Social Media', 'Copywriting'],
                'category' => 'Marketing',
                'location' => 'Remote',
                'work_type' => 'remote',
                'salary' => 8500,
                'application_deadline' => now()->addDays(19),
            ],
            [
                'title' => 'SEO Specialist',
                'description' => 'Improve organic search rankings through on-page and off-page optimization.',
                'required_skills' => ['SEO', 'Google Analytics', 'Keyword Research'],
                'category' => 'Marketing',
                'location' => 'Cairo, Egypt',
                'work_type' => 'hybrid',
                'salary' => 9500,
                'application_deadline' => now()->addDays(24),
            ],
            [
                'title' => 'Customer Support Agent',
                'description' => 'Handle customer inquiries via chat and email, and escalate issues when needed.',
                'required_skills' => ['Communication', 'Zendesk'],
                'category' => 'Customer Support',
                'location' => 'Remote',
                'work_type' => 'remote',
                'salary' => 7000,
                'application_deadline' => now()->addDays(25),
            ],
                        [
                'title' => 'Technical Support Engineer',
                'description' => 'Provide first-line technical support and escalate complex issues to engineering.',
                'required_skills' => ['Troubleshooting', 'SQL', 'Communication'],
                'category' => 'Customer Support',
                'location' => 'Cairo, Egypt',
                'work_type' => 'on-site',
                'salary' => 8000,
                'application_deadline' => now()->addDays(17),
            ],
            [
                'title' => 'Customer Success Manager',
                'description' => 'Build long-term relationships with key accounts and reduce churn.',
                'required_skills' => ['Account Management', 'Communication', 'CRM'],
                'category' => 'Customer Support',
                'location' => 'Giza, Egypt',
                'work_type' => 'hybrid',
                'salary' => 10000,
                'application_deadline' => now()->addDays(21),
            ],
                        [
                'title' => 'Data Analyst',
                'description' => 'Analyze business data and build dashboards to support decision making.',
                'required_skills' => ['SQL', 'Power BI', 'Python', 'Excel'],
                'category' => 'Data & Analytics',
                'location' => 'Cairo, Egypt',
                'work_type' => 'hybrid',
                'salary' => 13000,
                'application_deadline' => now()->addDays(40),
            ],
            [
                'title' => 'Data Scientist',
                'description' => 'Build predictive models and extract insights from large datasets.',
                'required_skills' => ['Python', 'Machine Learning', 'SQL'],
                'category' => 'Data & Analytics',
                'location' => 'Remote',
                'work_type' => 'remote',
                'salary' => 18000,
                'application_deadline' => now()->addDays(33),
            ],
            [
                'title' => 'Business Intelligence Analyst',
                'description' => 'Turn raw data into actionable reports for leadership and stakeholders.',
                'required_skills' => ['Power BI', 'SQL', 'Data Modeling'],
                'category' => 'Data & Analytics',
                'location' => 'Cairo, Egypt',
                'work_type' => 'on-site',
                'salary' => 12500,
                'application_deadline' => now()->addDays(27),
            ],
        ];

        foreach ($jobs as $job) {
            $category = Category::where('name', $job['category'])->first();

            JobPost::firstOrCreate(
                ['title' => $job['title']],
                [
                    'admin_id' => $admin->id,
                    'category_id' => $category?->id,
                    'description' => $job['description'],
                    'required_skills' => $job['required_skills'],
                    'location' => $job['location'],
                    'work_type' => $job['work_type'],
                    'salary' => $job['salary'],
                    'application_deadline' => $job['application_deadline'],
                ]
            );
        }
    }
}