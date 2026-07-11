@extends('layouts.admin')

@section('content')
@php
    $conversion = $leadStats->sum() ? round((($leadStats['won'] ?? 0) / $leadStats->sum()) * 100, 2) : 0;
    $statCards = [
        [
            'label' => 'Orders',
            'value' => $orderCount,
            'icon' => 'fa-shopping-bag',
            'class' => 'stat-blue',
            'href' => route('admin.orders.index'),
            'link' => 'View orders',
        ],
        [
            'label' => 'Invoices',
            'value' => $invoiceCount,
            'icon' => 'fa-file-invoice',
            'class' => 'stat-emerald',
            'href' => route('admin.invoices.index'),
            'link' => 'View invoices',
        ],
        [
            'label' => 'Users',
            'value' => $userCount,
            'icon' => 'fa-user-friends',
            'class' => 'stat-amber',
            'href' => route('admin.users.index'),
            'link' => 'View users',
        ],
        [
            'label' => 'Enquiries',
            'value' => $enquiryCount,
            'icon' => 'fa-bell',
            'class' => 'stat-rose',
            'href' => route('admin.leads.index'),
            'link' => 'View enquiries',
        ],
    ];

    $metrics = [
        ['label' => 'Total Revenue', 'value' => '$'.number_format($paidRevenue, 2), 'sub' => 'Paid invoices', 'class' => 'metric-slate'],
        ['label' => 'Recent Orders', 'value' => $recentOrderCount, 'sub' => 'Last 7 days', 'class' => 'metric-blue'],
        ['label' => 'New Users', 'value' => $newUserCount, 'sub' => 'Last 30 days', 'class' => 'metric-emerald'],
        ['label' => 'Conversion', 'value' => $conversion.'%', 'sub' => 'Won leads', 'class' => 'metric-amber'],
    ];
@endphp

<div class="dashboard-page">
    <section class="dashboard-header">
        <div>
            <span class="dashboard-kicker">Admin Overview</span>
            <h1 class="dashboard-title">Dashboard</h1>
            <p class="dashboard-subtitle">View and manage orders, invoices, users, and customer requests.</p>
        </div>
        <div class="dashboard-header-actions">
            <a href="{{ route('admin.invoices.create') }}" class="dashboard-btn dashboard-btn-primary">
                <i class="fa-solid fa-plus"></i> New Invoice
            </a>
            <a href="{{ route('admin.users.index') }}" class="dashboard-btn dashboard-btn-outline">
                <i class="fa-solid fa-users"></i> Manage Users
            </a>
            <a href="{{ route('admin.products.index') }}" class="dashboard-btn dashboard-btn-outline">
                <i class="fa-solid fa-cogs"></i> Manage Products
            </a>
            <a href="{{ route('admin.store-menu.index') }}" class="dashboard-btn dashboard-btn-outline">
                <i class="fa-solid fa-bars-staggered"></i> Store Menu
            </a>
        </div>
    </section>

    <nav class="dashboard-breadcrumb" aria-label="Breadcrumb">
        <a href="{{ url('/') }}">Home</a>
        <span>/</span>
        <span>Dashboard</span>
    </nav>

    <section class="dashboard-grid stats-grid">
        @foreach ($statCards as $card)
            <div class="dashboard-stat {{ $card['class'] }}">
                <div class="stat-header">
                    <span class="stat-icon"><i class="fa-solid {{ $card['icon'] }}"></i></span>
                    <span class="stat-label">{{ $card['label'] }}</span>
                </div>
                <div class="stat-value">{{ $card['value'] }}</div>
                <a href="{{ $card['href'] }}" class="stat-link">
                    {{ $card['link'] }} <i class="fa-solid fa-arrow-right"></i>
                </a>
            </div>
        @endforeach
    </section>

    <section class="dashboard-grid metrics-grid">
        @foreach ($metrics as $metric)
            <div class="dashboard-metric {{ $metric['class'] }}">
                <div class="metric-label">{{ $metric['label'] }}</div>
                <div class="metric-value">{{ $metric['value'] }}</div>
                <div class="metric-sub">{{ $metric['sub'] }}</div>
            </div>
        @endforeach
    </section>

    <section class="dashboard-panels">
        <div class="card dashboard-panel">
            <div class="dashboard-panel-header">
                <h2 class="dashboard-panel-title">Recent Activities</h2>
                <span class="dashboard-panel-meta">Latest updates</span>
            </div>
            <ul class="dashboard-activity-list">
                @forelse ($recentOrders as $order)
                    <li class="dashboard-activity-item">
                        <div>
                            <div class="activity-title">Order from {{ $order->customer_name }}</div>
                            <div class="activity-meta">{{ ucfirst(str_replace('_', ' ', $order->status)) }} order created {{ $order->created_at->format('M d, Y') }}</div>
                        </div>
                        <a href="{{ route('admin.orders.show', $order) }}" class="activity-link">View</a>
                    </li>
                @empty
                    <li class="dashboard-activity-item">
                        <div class="activity-title">No recent orders yet.</div>
                    </li>
                @endforelse

                @foreach ($recentLeads->take(3) as $lead)
                    <li class="dashboard-activity-item">
                        <div>
                            <div class="activity-title">Request from {{ $lead->name }}</div>
                            <div class="activity-meta">{{ ucfirst($lead->status) }} enquiry created {{ $lead->created_at->format('M d, Y') }}</div>
                        </div>
                        <a href="{{ route('admin.leads.edit', $lead) }}" class="activity-link">View</a>
                    </li>
                @endforeach
            </ul>
        </div>

        <div class="card dashboard-panel">
            <div class="dashboard-panel-header">
                <h2 class="dashboard-panel-title">Quick Actions</h2>
                <span class="dashboard-panel-meta">Shortcuts</span>
            </div>
            <div class="dashboard-action-list">
                <a href="{{ route('admin.invoices.create') }}" class="dashboard-action-link">
                    <span class="action-icon"><i class="fa-solid fa-plus"></i></span>
                    <span>
                        <strong>Add New Invoice</strong>
                        <small>Generate and track payment requests</small>
                    </span>
                </a>
                <a href="{{ route('admin.users.index') }}" class="dashboard-action-link">
                    <span class="action-icon"><i class="fa-solid fa-users"></i></span>
                    <span>
                        <strong>Manage Users</strong>
                        <small>Review accounts, roles, and permissions</small>
                    </span>
                </a>
                <a href="{{ route('admin.products.index') }}" class="dashboard-action-link">
                    <span class="action-icon"><i class="fa-solid fa-cogs"></i></span>
                    <span>
                        <strong>Manage Products</strong>
                        <small>Update pricing and availability</small>
                    </span>
                </a>
                <a href="{{ route('admin.store-menu.index') }}" class="dashboard-action-link">
                    <span class="action-icon"><i class="fa-solid fa-bars-staggered"></i></span>
                    <span>
                        <strong>Edit Store Menu</strong>
                        <small>Show, hide, and order storefront navigation items</small>
                    </span>
                </a>
            </div>
        </div>
    </section>

    <section class="dashboard-panels dashboard-secondary">
        <div class="card dashboard-panel">
            <div class="dashboard-panel-header">
                <h2 class="dashboard-panel-title">Order Status</h2>
                <span class="dashboard-panel-meta">Current pipeline</span>
            </div>
            <div class="status-list">
                @foreach (\App\Models\Order::STATUSES as $status)
                    <div class="status-row">
                        <span>{{ ucfirst(str_replace('_', ' ', $status)) }}</span>
                        <strong>{{ $orderStats[$status] ?? 0 }}</strong>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card dashboard-panel">
            <div class="dashboard-panel-header">
                <h2 class="dashboard-panel-title">Popular Blog Posts</h2>
                <span class="dashboard-panel-meta">Top views</span>
            </div>
            <div class="status-list">
                @forelse ($topPosts as $post)
                    <div class="status-row">
                        <span>{{ $post->title }}</span>
                        <strong>{{ $post->view_count }}</strong>
                    </div>
                @empty
                    <div class="status-row">
                        <span>No posts yet.</span>
                        <strong>0</strong>
                    </div>
                @endforelse
            </div>
        </div>
    </section>
</div>

<style>
    .dashboard-page {
        display: grid;
        gap: 20px;
    }

    .dashboard-header {
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
    }

    .dashboard-kicker {
        display: inline-flex;
        padding: 6px 14px;
        border-radius: 999px;
        background: #e2e8f0;
        color: #475569;
        font-size: 0.7rem;
        letter-spacing: 0.2em;
        text-transform: uppercase;
        font-weight: 600;
    }

    .dashboard-title {
        margin: 8px 0 6px;
        font-size: 2rem;
        color: #0f172a;
        font-weight: 600;
    }

    .dashboard-subtitle {
        margin: 0;
        color: #64748b;
        font-size: 0.95rem;
    }

    .dashboard-header-actions {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        align-items: center;
    }

    .dashboard-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border-radius: 999px;
        padding: 8px 14px;
        font-weight: 600;
        font-size: 0.86rem;
        text-decoration: none;
    }

    .dashboard-btn-primary {
        color: #ffffff;
        background: #2563eb;
        border: 1px solid #2563eb;
    }

    .dashboard-btn-outline {
        color: #475569;
        background: #ffffff;
        border: 1px solid #cbd5e1;
    }

    .dashboard-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 10px 20px rgba(15, 23, 42, 0.10);
    }

    .dashboard-breadcrumb {
        justify-self: end;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #94a3b8;
        font-size: 0.82rem;
    }

    .dashboard-breadcrumb a {
        color: #2563eb;
        text-decoration: none;
        font-weight: 600;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 16px;
    }

    .dashboard-stat {
        background: #ffffff;
        border-radius: 18px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 18px 32px rgba(15, 23, 42, 0.08);
        position: relative;
        overflow: hidden;
        min-height: 150px;
    }

    .dashboard-stat::after {
        content: "";
        position: absolute;
        right: -40px;
        top: -40px;
        width: 120px;
        height: 120px;
        border-radius: 50%;
        background: var(--stat-glow);
        opacity: 0.12;
    }

    .stat-header {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--stat-soft);
        color: var(--stat-accent);
        font-size: 18px;
    }

    .stat-label,
    .metric-label {
        font-size: 0.78rem;
        text-transform: uppercase;
        letter-spacing: 0.12em;
        color: #64748b;
        font-weight: 600;
    }

    .stat-value {
        font-size: 1.9rem;
        font-weight: 600;
        color: #0f172a;
        margin: 10px 0 8px;
    }

    .stat-link {
        font-size: 0.85rem;
        text-decoration: none;
        color: var(--stat-accent);
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-weight: 600;
    }

    .stat-blue {
        --stat-accent: #2563eb;
        --stat-soft: rgba(37, 99, 235, 0.12);
        --stat-glow: #2563eb;
    }

    .stat-emerald {
        --stat-accent: #059669;
        --stat-soft: rgba(5, 150, 105, 0.12);
        --stat-glow: #059669;
    }

    .stat-amber {
        --stat-accent: #d97706;
        --stat-soft: rgba(217, 119, 6, 0.12);
        --stat-glow: #d97706;
    }

    .stat-rose {
        --stat-accent: #e11d48;
        --stat-soft: rgba(225, 29, 72, 0.12);
        --stat-glow: #e11d48;
    }

    .dashboard-metric {
        background: #ffffff;
        border-radius: 16px;
        padding: 18px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 14px 26px rgba(15, 23, 42, 0.06);
        position: relative;
        overflow: hidden;
    }

    .dashboard-metric::before {
        content: "";
        position: absolute;
        left: 0;
        top: 0;
        height: 4px;
        width: 100%;
        background: var(--metric-accent);
    }

    .metric-value {
        font-size: 1.4rem;
        font-weight: 600;
        color: #0f172a;
        margin: 10px 0 6px;
    }

    .metric-sub {
        color: #94a3b8;
        font-size: 0.85rem;
    }

    .metric-slate { --metric-accent: #334155; }
    .metric-blue { --metric-accent: #3b82f6; }
    .metric-emerald { --metric-accent: #10b981; }
    .metric-amber { --metric-accent: #f59e0b; }

    .dashboard-panels {
        display: grid;
        grid-template-columns: minmax(0, 7fr) minmax(320px, 5fr);
        gap: 16px;
    }

    .dashboard-secondary {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }

    .dashboard-panel {
        overflow: hidden;
    }

    .dashboard-panel-header {
        padding: 18px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .dashboard-panel-title {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
        color: #0f172a;
    }

    .dashboard-panel-meta {
        font-size: 0.8rem;
        color: #94a3b8;
        white-space: nowrap;
    }

    .dashboard-activity-list {
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .dashboard-activity-item {
        padding: 14px 20px;
        border-bottom: 1px dashed #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
    }

    .dashboard-activity-item:last-child {
        border-bottom: none;
    }

    .activity-title {
        font-weight: 600;
        color: #0f172a;
        margin-bottom: 4px;
    }

    .activity-meta {
        font-size: 0.8rem;
        color: #94a3b8;
    }

    .activity-link {
        color: #2563eb;
        font-weight: 600;
        text-decoration: none;
        font-size: 0.85rem;
    }

    .dashboard-action-list {
        display: grid;
        gap: 12px;
        padding: 18px 20px 20px;
    }

    .dashboard-action-link {
        display: flex;
        align-items: flex-start;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 14px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #0f172a;
        text-decoration: none;
    }

    .dashboard-action-link:hover {
        background: #eef2ff;
        border-color: #c7d2fe;
        color: #1e3a8a;
    }

    .dashboard-action-link small {
        display: block;
        color: #64748b;
        font-size: 0.82rem;
    }

    .action-icon {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        background: #e0e7ff;
        color: #1d4ed8;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .status-list {
        padding: 10px 20px 18px;
    }

    .status-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        padding: 11px 0;
        border-bottom: 1px dashed #e2e8f0;
        color: #475569;
    }

    .status-row:last-child {
        border-bottom: none;
    }

    .status-row span {
        min-width: 0;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .status-row strong {
        color: #0f172a;
        font-weight: 600;
    }

    @media (max-width: 1100px) {
        .dashboard-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .dashboard-panels,
        .dashboard-secondary {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 640px) {
        .dashboard-title {
            font-size: 1.6rem;
        }

        .dashboard-header-actions {
            width: 100%;
        }

        .dashboard-btn {
            flex: 1 1 100%;
            justify-content: center;
        }

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .dashboard-breadcrumb {
            justify-self: start;
        }
    }
</style>
@endsection
