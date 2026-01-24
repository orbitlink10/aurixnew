<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        body { background: #f5f7fb; color: #0f172a; font-family: 'Inter', system-ui, -apple-system, sans-serif; }
        .card { background: #ffffff; border: 1px solid #e5e7eb; box-shadow: 0 10px 35px rgba(15, 23, 42, 0.08); border-radius: 14px; }
        .nav-link { color: #cbd5e1; font-weight: 600; display: block; padding: 10px 14px; border-radius: 10px; }
        .nav-link:hover { background: rgba(255,255,255,0.08); color: #fff; }
        .nav-link.active { background: #1f2937; color: #fff; }
        .pill { background: linear-gradient(120deg, #0ea5e9, #22d3ee); color: #0b1e34; font-weight: 600; }
        .btn { transition: all 0.15s ease; }
        .page-title { font-weight: 800; color: #0f172a; letter-spacing: -0.02em; }
        .glass { backdrop-filter: blur(6px); background: rgba(255,255,255,0.85); border: 1px solid rgba(226,232,240,0.8); }
    </style>
</head>
<body class="min-h-screen">
    <div class="min-h-screen flex">
        {{-- Sidebar --}}
        <aside class="w-64 bg-slate-900 text-white flex flex-col">
            <div class="h-16 flex items-center px-5 text-2xl font-bold tracking-tight border-b border-slate-800">
                AURIX
            </div>
            <div class="px-4 py-4 text-xs uppercase text-slate-400">Menu</div>
            <nav class="px-3 space-y-1 text-sm flex-1">
                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboards</a>
                <a class="nav-link" href="{{ url('/') }}" target="_blank">Home</a>
                <a class="nav-link" href="{{ route('admin.services.index') }}">Services</a>
                <a class="nav-link" href="{{ route('admin.packages.index') }}">Packages</a>
                <a class="nav-link" href="{{ route('admin.leads.index') }}">Leads</a>
                <a class="nav-link" href="{{ route('admin.orders.index') }}">Orders</a>
                <a class="nav-link" href="{{ route('admin.blog-posts.index') }}">Blog</a>
                <a class="nav-link" href="{{ route('admin.slider-images.index') }}">Slider Images</a>
                <a class="nav-link" href="{{ route('admin.reports.index') }}">Reports</a>
                <a class="nav-link" href="{{ route('admin.users.index') }}">Users</a>
            </nav>
            <div class="px-4 py-4 border-t border-slate-800 text-xs text-slate-400">
                {{ auth()->user()->email ?? '' }}
            </div>
        </aside>

        {{-- Main --}}
        <div class="flex-1 flex flex-col">
            <header class="h-16 bg-white shadow-sm flex items-center justify-between px-6">
                <div class="flex items-center gap-3 w-full">
                    <input type="text" placeholder="Search…" class="w-72 bg-slate-100 border border-slate-200 rounded px-3 py-2 text-sm">
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-slate-600">{{ auth()->user()->name ?? 'Guest' }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn bg-slate-900 text-white px-3 py-1 rounded">Logout</button>
                    </form>
                </div>
            </header>

            <main class="px-6 py-6 space-y-4">
                @if (session('success'))
                    <div class="card p-3 text-emerald-700 border border-emerald-100 bg-emerald-50">{{ session('success') }}</div>
                @endif
                @if ($errors->any())
                    <div class="card p-3 text-rose-700 border border-rose-100 bg-rose-50">
                        <ul class="list-disc list-inside space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
