@extends('layouts.app')
@section('title', 'Register')

@section('content')
<div class="max-w-sm mx-auto bg-white border border-slate-200 rounded-lg p-6">
    <h1 class="text-lg font-semibold mb-4">Create your candidate account</h1>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required autofocus
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Confirm Password</label>
            <input type="password" name="password_confirmation" required
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">
            Register
        </button>
    </form>

    <p class="text-sm text-slate-500 mt-4">
        Already have an account? <a href="{{ route('login') }}" class="text-indigo-600">Login</a>
    </p>
</div>
@endsection
