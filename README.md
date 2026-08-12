<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

# AI Job Board

<p align="left">
  <img src="https://skillicons.dev/icons?i=php,laravel,mysql,tailwind,js,html" />
</p>

A Laravel-based Job Board System where candidates can create profiles, browse available jobs, and apply for them. Includes an AI-assisted chatbot that helps candidates find matching jobs and helps admins query platform statistics — all built without external AI APIs, using rule-based logic on top of the platform's own data.

## Features

### Candidate
- Register, log in, log out
- Edit profile: full name, age, job title, description, phone number, skills, profile image, resume (CV)
- Browse available jobs with search, category, and work-type filters
- View job details
- Apply to a job / cancel an application
- View own application history

### Admin
- Create, edit, and delete job postings
- View all registered candidates (searchable) and their full profiles
- View all job applications, filterable by status
- Role-protected admin panel (`/admin/*`), inaccessible to candidates

### AI Chatbot
A floating chat widget available to logged-in users on every page.

**Candidates can ask:**
- "Which jobs match my skills?"
- "What are the best jobs for me?"
- "What skills should I learn?"

**Admins can ask:**
- "How many candidates are registered?"
- "Which job has the most applications?"
- "List all available jobs"
- "Show jobs in the [category] category"

The chatbot compares the candidate's stored skills against each job's required skills (both stored as JSON arrays) to rank matches and suggest skill gaps — no external AI API is used.

## Tech Stack

| Layer | Technology |
|---|---|
| Backend | Laravel 10, PHP 8.2+ |
| Database | MySQL |
| Frontend | Blade templates + Tailwind CSS (via CDN, no build step) |
| Auth | Laravel's built-in session-based Auth, with a `role` column on `users` |

## Database Schema

| Table | Purpose |
|---|---|
| `users` | Auth table, extended with a `role` enum (`candidate` / `admin`) |
| `candidate_profiles` | 1:1 with users — name, age, job title, description, phone, skills (JSON), profile image, resume |
| `categories` | Job categories |
| `job_posts` | Job listings — required skills stored as JSON, work type, salary, deadline |
| `job_applications` | Links a candidate to a job, with status (pending/cancelled/accepted/rejected) |

## Setup

1. Clone the repo and install dependencies:
```bash
   git clone <repo-url>
   cd job-board
   composer install
```

2. Copy the environment file and generate an app key:
```bash
   cp .env.example .env
   php artisan key:generate
```

3. Create a MySQL database (e.g. `job_board`) and set your credentials in `.env`:
```
   DB_DATABASE=job_board
   DB_USERNAME=root
   DB_PASSWORD=
```

4. Run migrations and link storage:
```bash
   php artisan migrate
   php artisan storage:link
```

5. (Optional) Seed sample data — categories, jobs, an admin account, and candidate accounts:
```bash
   php artisan db:seed
```

6. Start the server:
```bash
   php artisan serve
```
   Visit `http://127.0.0.1:8000`

### Test accounts (after seeding)

| Role | Email | Password |
|---|---|---|
| Admin | admin@example.com | password |
| Candidate | ahmed@example.com | password |
| Candidate | sara@example.com | password |
| Candidate | mohamed@example.com | password |

## Project Structure

```
app/Http/Controllers/        Web controllers (Auth, Profile, Job, JobApplication, Chatbot)
app/Http/Controllers/Admin/  Admin-only controllers (Job CRUD, Candidates, Applications)
app/Http/Middleware/         EnsureUserIsAdmin - blocks non-admins from /admin/*
app/Models/                  User, CandidateProfile, Category, JobPost, JobApplication
database/migrations/         Schema for all tables above
database/seeders/            Sample data (users, categories, jobs, applications)
resources/views/             Blade templates, styled with Tailwind
routes/web.php                All application routes
```

## Routes Overview

| Method | URI | Middleware | Description |
|---|---|---|---|
| GET/POST | `/register`, `/login` | guest | Candidate registration and login |
| POST | `/logout` | auth | Logout |
| GET | `/jobs`, `/jobs/{job}` | - | Browse and view jobs |
| GET/PUT | `/profile` | auth | Edit candidate profile |
| POST | `/jobs/{job}/apply` | auth | Apply to a job |
| DELETE | `/applications/{id}` | auth | Cancel an application |
| GET | `/my-applications` | auth | Candidate's own applications |
| POST | `/chatbot` | auth | Chatbot query endpoint |
| resource | `/admin/jobs` | auth, admin | Job CRUD |
| GET | `/admin/candidates` | auth, admin | View all candidates |
| GET | `/admin/applications` | auth, admin | View all applications |

## Known Limitations

- The AI job recommendation on the candidate's profile page (bonus feature) is not yet implemented — the chatbot's skill-matching logic covers a similar use case on request.
- No automated tests yet.
- Validation lives inline in controllers rather than in dedicated Form Request classes.
- Category management has no admin UI yet (managed via seeders / database directly).

## Author

Built as a Laravel summer training project — AI Job Board.frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.
## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
