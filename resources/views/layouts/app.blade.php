<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'AI Job Board')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-50 text-slate-900 min-h-screen flex flex-col">

    <nav class="bg-white border-b border-slate-200">
        <div class="max-w-5xl mx-auto px-4 h-14 flex items-center justify-between">
            <a href="{{ route('jobs.index') }}" class="font-semibold text-indigo-600">AI Job Board</a>

            <div class="flex items-center gap-4 text-sm">
                <a href="{{ route('jobs.index') }}" class="text-slate-600 hover:text-slate-900">Browse Jobs</a>

                @auth
                    @if (auth()->user()->isAdmin())
                        <a href="{{ route('admin.jobs.index') }}" class="text-slate-600 hover:text-slate-900">Manage Jobs</a>
                        <a href="{{ route('admin.candidates.index') }}" class="text-slate-600 hover:text-slate-900">Candidates</a>
                        <a href="{{ route('admin.applications.index') }}" class="text-slate-600 hover:text-slate-900">Applications</a>
                    @else
                        <a href="{{ route('applications.index') }}" class="text-slate-600 hover:text-slate-900">My Applications</a>
                        <a href="{{ route('profile.edit') }}" class="text-slate-600 hover:text-slate-900">Profile</a>
                    @endif

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="text-slate-600 hover:text-red-600">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="text-slate-600 hover:text-slate-900">Login</a>
                    <a href="{{ route('register') }}" class="bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700">Register</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-5xl w-full mx-auto px-4 py-8">
        @if (session('status'))
            <div class="mb-4 rounded-md bg-green-50 border border-green-200 text-green-800 px-4 py-2 text-sm">
                {{ session('status') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-2 text-sm">
                {{ session('error') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 rounded-md bg-red-50 border border-red-200 text-red-800 px-4 py-2 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @yield('content')
    </main>

    @auth
    <div id="chatbot-widget" class="fixed bottom-5 right-5 z-50">
        <button id="chatbot-toggle"
                class="bg-indigo-600 hover:bg-indigo-700 text-white rounded-full w-14 h-14 shadow-lg flex items-center justify-center text-2xl">
            💬
        </button>

        <div id="chatbot-panel" class="hidden mt-3 w-80 bg-white border border-slate-200 rounded-lg shadow-xl flex flex-col" style="height: 420px;">
            <div class="bg-indigo-600 text-white text-sm font-medium px-4 py-3 rounded-t-lg">
                Job Board Assistant
            </div>

            <div id="chatbot-messages" class="flex-1 overflow-y-auto p-3 space-y-2 text-sm">
                <div class="bg-slate-100 text-slate-700 rounded-lg px-3 py-2 max-w-[85%] whitespace-pre-line">
                    @if (auth()->user()->isAdmin())
                        Hi! Ask me things like "How many candidates are registered?" or "Which job has the most applications?"
                    @else
                        Hi! Ask me things like "Which jobs match my skills?" or "What skills should I learn?"
                    @endif
                </div>
            </div>

            <form id="chatbot-form" class="border-t border-slate-200 p-2 flex gap-2">
                <input id="chatbot-input" type="text" placeholder="Type a message..."
                       class="flex-1 rounded-md border-slate-300 text-sm shadow-sm" autocomplete="off">
                <button type="submit" class="bg-indigo-600 text-white px-3 py-1.5 rounded-md text-sm hover:bg-indigo-700">
                    Send
                </button>
            </form>
        </div>
    </div>

    <script>
        (function () {
            const toggle = document.getElementById('chatbot-toggle');
            const panel = document.getElementById('chatbot-panel');
            const form = document.getElementById('chatbot-form');
            const input = document.getElementById('chatbot-input');
            const messages = document.getElementById('chatbot-messages');

            toggle.addEventListener('click', () => panel.classList.toggle('hidden'));

            function addMessage(text, fromUser) {
                const bubble = document.createElement('div');
                bubble.className = fromUser
                    ? 'bg-indigo-600 text-white rounded-lg px-3 py-2 max-w-[85%] ml-auto whitespace-pre-line'
                    : 'bg-slate-100 text-slate-700 rounded-lg px-3 py-2 max-w-[85%] whitespace-pre-line';
                bubble.textContent = text;
                messages.appendChild(bubble);
                messages.scrollTop = messages.scrollHeight;
            }

            form.addEventListener('submit', async function (e) {
                e.preventDefault();
                const text = input.value.trim();
                if (!text) return;

                addMessage(text, true);
                input.value = '';

                try {
                    const response = await fetch('{{ route('chatbot.ask') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: JSON.stringify({ message: text }),
                    });

                    const data = await response.json();
                    addMessage(data.reply ?? 'Sorry, something went wrong.', false);
                } catch (err) {
                    addMessage('Sorry, something went wrong reaching the assistant.', false);
                }
            });
        })();
    </script>
    @endauth

</body>
</html>