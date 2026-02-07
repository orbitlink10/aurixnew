@extends('layouts.admin')

@section('content')
<div class="mb-4">
    <h1 class="text-2xl font-bold text-slate-900">Reports</h1>
    <p class="text-slate-500 text-sm">Revenue, funnel performance, order pipeline, and content performance.</p>
</div>

<div class="grid md:grid-cols-4 gap-4">
    <div class="card p-4">
        <p class="text-xs uppercase tracking-wide text-slate-500">Months Reported</p>
        <p class="text-2xl font-bold text-slate-900 mt-1">{{ $salesByMonth->count() }}</p>
    </div>
    <div class="card p-4">
        <p class="text-xs uppercase tracking-wide text-slate-500">Total Sales</p>
        <p class="text-2xl font-bold text-slate-900 mt-1">${{ number_format($salesByMonth->sum('total'), 2) }}</p>
    </div>
    <div class="card p-4">
        <p class="text-xs uppercase tracking-wide text-slate-500">Lead Conversion</p>
        <p class="text-2xl font-bold text-slate-900 mt-1">{{ number_format($conversionRate, 2) }}%</p>
    </div>
    <div class="card p-4">
        <p class="text-xs uppercase tracking-wide text-slate-500">Top Posts Tracked</p>
        <p class="text-2xl font-bold text-slate-900 mt-1">{{ $popularPosts->count() }}</p>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div class="card p-4">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Sales by Month</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="text-slate-500">
                    <tr>
                        <th class="text-left py-2">Month</th>
                        <th class="text-right py-2">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($salesByMonth as $row)
                        <tr class="border-t border-slate-200">
                            <td class="py-2 text-slate-800">{{ $row->month }}</td>
                            <td class="py-2 text-right font-semibold text-slate-900">${{ number_format((float) $row->total, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td class="py-2 text-slate-500" colspan="2">No issued invoices yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="card p-4">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Lead Funnel</h2>
        <div class="space-y-2 text-sm">
            @foreach(['new','contacted','quoted','won','lost'] as $status)
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <span class="capitalize text-slate-700">{{ $status }}</span>
                    <span class="font-semibold text-slate-900">{{ $leadFunnel[$status] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div class="card p-4">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Order Status</h2>
        <div class="space-y-2 text-sm">
            @foreach(\App\Models\Order::STATUSES as $status)
                <div class="flex items-center justify-between border-b border-slate-100 pb-2">
                    <span class="capitalize text-slate-700">{{ str_replace('_', ' ', $status) }}</span>
                    <span class="font-semibold text-slate-900">{{ $orderStatus[$status] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="card p-4">
        <h2 class="text-lg font-semibold text-slate-900 mb-3">Popular Blog Posts</h2>
        <div class="space-y-2 text-sm">
            @forelse($popularPosts as $post)
                <div class="flex items-center justify-between border-b border-slate-100 pb-2 gap-4">
                    <span class="text-slate-700 truncate">{{ $post->title }}</span>
                    <span class="font-semibold text-slate-900 shrink-0">{{ $post->view_count }} views</span>
                </div>
            @empty
                <p class="text-slate-500">No blog posts yet.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
