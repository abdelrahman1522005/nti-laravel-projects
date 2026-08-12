@php $job ??= null; @endphp

<div>
    <label class="block text-sm font-medium mb-1">Title</label>
    <input type="text" name="title" value="{{ old('title', $job->title ?? '') }}" required
           class="w-full rounded-md border-slate-300 shadow-sm">
</div>

<div>
    <label class="block text-sm font-medium mb-1">Description</label>
    <textarea name="description" rows="5" required
              class="w-full rounded-md border-slate-300 shadow-sm">{{ old('description', $job->description ?? '') }}</textarea>
</div>

<div>
    <label class="block text-sm font-medium mb-1">Required Skills (comma-separated)</label>
    <input type="text" name="required_skills" placeholder="PHP, Laravel, MySQL"
           value="{{ old('required_skills', isset($job) && $job->required_skills ? implode(', ', $job->required_skills) : '') }}"
           class="w-full rounded-md border-slate-300 shadow-sm">
</div>

<div class="grid grid-cols-2 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Category</label>
        <select name="category_id" class="w-full rounded-md border-slate-300 shadow-sm">
            <option value="">None</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $job->category_id ?? '') == $category->id)>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Location</label>
        <input type="text" name="location" value="{{ old('location', $job->location ?? '') }}"
               class="w-full rounded-md border-slate-300 shadow-sm">
    </div>
</div>

<div class="grid grid-cols-3 gap-4">
    <div>
        <label class="block text-sm font-medium mb-1">Work Type</label>
        <select name="work_type" required class="w-full rounded-md border-slate-300 shadow-sm">
            @foreach (['remote' => 'Remote', 'on-site' => 'On-site', 'hybrid' => 'Hybrid'] as $value => $label)
                <option value="{{ $value }}" @selected(old('work_type', $job->work_type ?? '') == $value)>{{ $label }}</option>
            @endforeach
        </select>
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Salary</label>
        <input type="number" step="0.01" name="salary" value="{{ old('salary', $job->salary ?? '') }}"
               class="w-full rounded-md border-slate-300 shadow-sm">
    </div>
    <div>
        <label class="block text-sm font-medium mb-1">Application Deadline</label>
        <input type="date" name="application_deadline"
               value="{{ old('application_deadline', isset($job->application_deadline) ? $job->application_deadline->format('Y-m-d') : '') }}"
               class="w-full rounded-md border-slate-300 shadow-sm">
    </div>
</div>
