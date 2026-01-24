<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Aurix Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: radial-gradient(circle at 20% 20%, #1e293b, #0b1021 60%); color: #e5e7eb; }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="w-full max-w-md bg-slate-900/80 border border-slate-800 p-8 rounded-xl shadow-xl">
        <h1 class="text-2xl font-semibold text-white mb-6">Aurix Admin</h1>
        @if ($errors->any())
            <div class="mb-4 text-sm text-rose-200">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ url('/login') }}" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white" autofocus>
            </div>
            <div>
                <label class="block text-sm mb-1">Password</label>
                <input type="password" name="password" required class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div class="flex items-center justify-between text-sm text-slate-300">
                <label class="inline-flex items-center gap-2">
                    <input type="checkbox" name="remember" class="accent-sky-500">
                    <span>Remember me</span>
                </label>
                <span class="text-slate-500">admin@aurix.test / password</span>
            </div>
            <button class="w-full bg-sky-500 hover:bg-sky-400 text-slate-900 font-semibold rounded px-4 py-2">Login</button>
        </form>
    </div>
</body>
</html>
