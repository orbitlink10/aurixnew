<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name') }} Admin</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --admin-bg: #f4f6fb;
            --admin-text: #0f172a;
            --admin-muted: #64748b;
            --admin-border: #e2e8f0;
            --admin-sidebar: #ffffff;
            --admin-accent: #2563eb;
        }

        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: var(--admin-bg);
            color: var(--admin-text);
            font-family: 'Poppins', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            font-size: 14px;
        }

        .admin-shell { min-height: 100vh; display: flex; }
        .main-sidebar {
            width: 260px;
            background: var(--admin-sidebar);
            border-right: 1px solid var(--admin-border);
            box-shadow: 0 16px 34px rgba(15, 23, 42, 0.08);
            position: fixed;
            inset: 0 auto 0 0;
            z-index: 30;
            overflow-y: auto;
        }
        .sidebar-brand {
            padding: 18px 20px 16px;
            border-bottom: 1px solid var(--admin-border);
        }
        .sidebar-brand h3 {
            margin: 0;
            color: #111827;
            font-size: 1.25rem;
            font-weight: 600;
        }
        .nav-section {
            padding: 16px 16px 4px;
            color: #94a3b8;
            font-size: 0.72rem;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            font-weight: 700;
        }
        .sidebar-nav { padding: 8px 12px 18px; }
        .nav-link {
            color: #334155;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: 10px;
            text-decoration: none;
            transition: background 0.15s ease, color 0.15s ease;
        }
        .nav-link i {
            width: 20px;
            color: #64748b;
            text-align: center;
            font-size: 0.95rem;
        }
        .nav-link:hover {
            background: #f1f5f9;
            color: #0f172a;
        }
        .nav-link.active {
            background: #e8f0ff;
            color: #1d4ed8;
            font-weight: 600;
        }
        .nav-link.active i { color: #2563eb; }

        .content-area {
            min-height: 100vh;
            margin-left: 260px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }
        .topbar {
            min-height: 64px;
            background: rgba(255, 255, 255, 0.92);
            border-bottom: 1px solid var(--admin-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            padding: 12px 24px;
            position: sticky;
            top: 0;
            z-index: 20;
            backdrop-filter: blur(10px);
        }
        .topbar-search {
            width: min(360px, 100%);
            background: #f8fafc;
            border: 1px solid var(--admin-border);
            border-radius: 999px;
            padding: 9px 14px;
            color: #334155;
            outline: none;
        }
        .topbar-search:focus {
            border-color: #93c5fd;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.10);
        }
        .user-chip {
            color: #475569;
            font-weight: 600;
            white-space: nowrap;
        }
        .btn {
            transition: all 0.15s ease;
            border-radius: 999px;
            font-weight: 600;
        }
        .logout-btn {
            background: #0f172a;
            color: #ffffff;
            padding: 8px 14px;
            font-size: 0.85rem;
        }
        .logout-btn:hover { background: #1e293b; }

        main.admin-main {
            padding: 24px;
            flex: 1;
        }
        .card {
            background: #ffffff;
            border: 1px solid var(--admin-border);
            box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
            border-radius: 18px;
        }
        .page-title {
            color: #0f172a;
            font-weight: 600;
            letter-spacing: 0;
        }
        .pill {
            background: #e8f0ff;
            color: #1d4ed8;
            font-weight: 600;
        }
        .glass {
            background: rgba(255, 255, 255, 0.90);
            border: 1px solid rgba(226, 232, 240, 0.9);
            backdrop-filter: blur(10px);
        }
        .bottom-navbar { display: none; }

        @media (max-width: 900px) {
            .main-sidebar { display: none; }
            .content-area { margin-left: 0; padding-bottom: 72px; }
            .topbar { padding: 12px 16px; }
            .topbar-search { display: none; }
            main.admin-main { padding: 18px 14px; }
            .bottom-navbar {
                position: fixed;
                left: 0;
                right: 0;
                bottom: 0;
                z-index: 40;
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                background: #003366;
                box-shadow: 0 -8px 20px rgba(15, 23, 42, 0.20);
                padding: 8px 6px;
            }
            .bottom-navbar a,
            .bottom-navbar button {
                color: #cbd5e1;
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
                gap: 4px;
                text-decoration: none;
                font-size: 0.68rem;
                min-height: 48px;
            }
            .bottom-navbar a.active { color: #ffffff; }
            .bottom-navbar i { font-size: 1rem; }
        }
    </style>
</head>
<body>
    <div class="admin-shell">
        <aside class="main-sidebar">
            <div class="sidebar-brand">
                <a href="{{ url('/') }}" class="text-decoration-none" aria-label="Go to homepage">
                    <h3>Aurix Branding</h3>
                </a>
            </div>

            <nav class="sidebar-nav">
                <div class="nav-section">Dashboard</div>
                <a class="nav-link {{ request()->is('admin') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
                </a>

                <div class="nav-section">Content Management</div>
                <a class="nav-link {{ request()->routeIs('admin.home-page-content.*') ? 'active' : '' }}" href="{{ route('admin.home-page-content.index') }}">
                    <i class="fa-solid fa-file-lines"></i><span>Homepage Content</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.services.*') ? 'active' : '' }}" href="{{ route('admin.services.index') }}">
                    <i class="fa-solid fa-screwdriver-wrench"></i><span>Services</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.store-menu.*') ? 'active' : '' }}" href="{{ route('admin.store-menu.index') }}">
                    <i class="fa-solid fa-bars-staggered"></i><span>Store Menu</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="fa-solid fa-list-alt"></i><span>Categories</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.sub-categories.*') ? 'active' : '' }}" href="{{ route('admin.sub-categories.index') }}">
                    <i class="fa-solid fa-tags"></i><span>Sub Categories</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                    <i class="fa-solid fa-boxes-stacked"></i><span>Products</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.packages.*') ? 'active' : '' }}" href="{{ route('admin.packages.index') }}">
                    <i class="fa-solid fa-tags"></i><span>Packages</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.blog-posts.*') || request()->routeIs('admin.pages.*') || request()->routeIs('admin.new-post') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                    <i class="fa-solid fa-pen-to-square"></i><span>Pages</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.slider-images.*') ? 'active' : '' }}" href="{{ route('admin.slider-images.index') }}">
                    <i class="fa-solid fa-images"></i><span>Sliders</span>
                </a>

                <div class="nav-section">Operations</div>
                <a class="nav-link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                    <i class="fa-solid fa-cart-shopping"></i><span>Orders</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}" href="{{ route('admin.invoices.index') }}">
                    <i class="fa-solid fa-file-invoice"></i><span>Invoices</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.leads.*') ? 'active' : '' }}" href="{{ route('admin.leads.index') }}">
                    <i class="fa-solid fa-bell"></i><span>Requests</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" href="{{ route('admin.reports.index') }}">
                    <i class="fa-solid fa-chart-line"></i><span>Reports</span>
                </a>

                <div class="nav-section">Admin Panel</div>
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="fa-solid fa-users"></i><span>Users</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.roles.*') ? 'active' : '' }}" href="{{ route('admin.roles.index') }}">
                    <i class="fa-solid fa-user-shield"></i><span>Roles</span>
                </a>
                <a class="nav-link {{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}" href="{{ route('admin.permissions.index') }}">
                    <i class="fa-solid fa-key"></i><span>Permissions</span>
                </a>
                <a class="nav-link" href="{{ url('/') }}" target="_blank">
                    <i class="fa-solid fa-house"></i><span>View Site</span>
                </a>

                <div class="nav-section">Account</div>
                <div class="nav-link">
                    <i class="fa-solid fa-user"></i><span>{{ auth()->user()->email ?? 'Guest' }}</span>
                </div>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="nav-link w-full text-left" type="submit">
                        <i class="fa-solid fa-right-from-bracket"></i><span>Logout</span>
                    </button>
                </form>
            </nav>
        </aside>

        <div class="content-area">
            <header class="topbar">
                <input type="text" placeholder="Search" class="topbar-search">
                <div class="flex items-center gap-3 ml-auto">
                    <span class="user-chip">{{ auth()->user()->name ?? 'Guest' }}</span>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button class="btn logout-btn" type="submit">
                            <i class="fa-solid fa-right-from-bracket mr-1"></i> Logout
                        </button>
                    </form>
                </div>
            </header>

            <main class="admin-main space-y-4">
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

    <div class="bottom-navbar">
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->is('admin') ? 'active' : '' }}">
            <i class="fa-solid fa-gauge-high"></i><span>Dashboard</span>
        </a>
        <a href="{{ route('admin.orders.index') }}" class="{{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
            <i class="fa-solid fa-cart-shopping"></i><span>Orders</span>
        </a>
        <a href="{{ route('admin.invoices.index') }}" class="{{ request()->routeIs('admin.invoices.*') ? 'active' : '' }}">
            <i class="fa-solid fa-file-invoice"></i><span>Invoices</span>
        </a>
        <a href="{{ route('admin.users.index') }}" class="{{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
            <i class="fa-solid fa-users"></i><span>Users</span>
        </a>
        <a href="{{ route('admin.products.index') }}" class="{{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
            <i class="fa-solid fa-bars"></i><span>More</span>
        </a>
    </div>
</body>
</html>
