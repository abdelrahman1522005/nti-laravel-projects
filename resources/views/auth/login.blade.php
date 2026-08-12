@extends('layouts.app')
@section('title', 'Login')

@section('content')
<div class="max-w-sm mx-auto bg-white border border-slate-200 rounded-lg p-6">
    <h1 class="text-lg font-semibold mb-4">Login</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required autofocus
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" required
                   class="w-full rounded-md border-slate-300 shadow-sm">
        </div>

        <label class="flex items-center gap-2 text-sm text-slate-600">
            <input type="checkbox" name="remember"> Remember me
        </label>

        <button type="submit" class="w-full bg-indigo-600 text-white py-2 rounded-md hover:bg-indigo-700">
            Login
        </button>
    </form>

    <p class="text-sm text-slate-500 mt-4">
        No account? <a href="{{ route('register') }}" class="text-indigo-600">Register</a>
    </p>
</div>
@endsection
