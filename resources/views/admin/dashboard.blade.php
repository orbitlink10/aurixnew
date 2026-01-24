@extends('layouts.admin')

@section('content')
<div class="mb-6 flex items-start justify-between">
    <div>
        <h1 class="text-3xl page-title mb-2">Executive Overview</h1>
        <p class="text-slate-500">Performance at a glance: revenue, pipeline, and engagement.</p>
    </div>
    <span class="inline-flex items-center gap-2 px-3 py-2 rounded-full glass shadow-sm">
        <span class="w-2 h-2 bg-emerald-500 rounded-full"></span>
        <span class="text-sm text-slate-700 font-semibold">All systems operational</span>
    </span>
</div>

<div class="grid md:grid-cols-4 gap-4">
    @php
        $cards = [
            ['label' => 'Services', 'value' => $serviceCount, 'accent' => 'from-sky-500/15 to-sky-100'],
            ['label' => 'Packages', 'value' => $packageCount, 'accent' => 'from-indigo-500/15 to-indigo-100'],
            ['label' => 'Paid Revenue', 'value' => '$'.number_format($paidRevenue, 2), 'accent' => 'from-emerald-500/15 to-emerald-100'],
            ['label' => 'Conversion', 'value' => (isset($leadStats['won']) && $leadStats->sum()) ? round(($leadStats['won'] ?? 0)/$leadStats->sum()*100,2).'%' : '0%', 'accent' => 'from-amber-500/15 to-amber-100'],
        ];
    @endphp
    @foreach ($cards as $card)
        <div class="card p-4 relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-br {{ $card['accent'] }}"></div>
            <div class="absolute right-4 top-4 text-slate-300 text-4xl font-black opacity-40">•</div>
            <div class="relative space-y-2">
                <p class="text-xs uppercase tracking-[0.12em] text-slate-500">{{ $card['label'] }}</p>
                <div class="text-3xl font-bold text-slate-900">{{ $card['value'] }}</div>
            </div>
        </div>
    @endforeach
</div>

{{-- Promo / hero strip --}}
<div class="card overflow-hidden">
    <div class="bg-amber-50 text-amber-700 px-4 py-2 text-sm flex items-center gap-2 border-b border-amber-100">
        <span>⚠</span> Your free trial expires soon. Upgrade now to unlock premium analytics.
    </div>
    <div class="p-5 flex items-center justify-between">
        <div>
            <p class="text-xl font-semibold text-slate-900">Upgrade from Free to Premium</p>
            <p class="text-slate-500 mt-1">Get deeper insights, exports, and advanced permissions.</p>
        </div>
        <button class="px-5 py-2 rounded bg-emerald-600 text-white font-semibold hover:bg-emerald-500">Upgrade Account</button>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div class="card p-4 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold">Order Status</h2>
            <span class="text-xs text-slate-500">Current pipeline</span>
        </div>
        <div class="space-y-2">
            @foreach (\App\Models\Order::STATUSES as $status)
                <div class="flex items-center justify-between text-sm">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $status === 'completed' ? 'bg-emerald-500' : ($status === 'in_progress' ? 'bg-amber-500' : 'bg-slate-300') }}"></span>
                        <span class="capitalize text-slate-700 font-medium">{{ str_replace('_',' ',$status) }}</span>
                    </div>
                    <span class="font-semibold text-slate-900">{{ $orderStats[$status] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>
    <div class="card p-4 rounded-xl">
        <div class="flex items-center justify-between mb-2">
            <h2 class="text-lg font-semibold">Lead Funnel</h2>
            <span class="text-xs text-slate-500">Last 90 days</span>
        </div>
        <div class="space-y-2">
            @foreach (['new','contacted','quoted','won','lost'] as $status)
                <div class="flex items-center justify-between text-sm">
                    <span class="capitalize text-slate-700 font-medium">{{ $status }}</span>
                    <span class="font-semibold text-slate-900">{{ $leadStats[$status] ?? 0 }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>

<div class="grid md:grid-cols-2 gap-4">
    <div class="card p-4 rounded-xl">
        <h2 class="text-lg font-semibold mb-3">Recent Orders</h2>
        <div class="space-y-2">
            @forelse ($recentOrders as $order)
                <div class="flex items-center justify-between text-sm bg-slate-50 rounded-lg px-3 py-2 border border-slate-100">
                    <div>
                        <div class="font-semibold text-slate-900">{{ $order->customer_name }}</div>
                        <div class="text-slate-500">{{ $order->status }} • {{ $order->created_at->format('M d') }}</div>
                    </div>
                    <a href="{{ route('admin.orders.show', $order) }}" class="text-sky-600 font-semibold">View</a>
                </div>
            @empty
                <p class="text-slate-500 text-sm">No orders yet.</p>
            @endforelse
        </div>
    </div>
    <div class="card p-4 rounded-xl">
        <h2 class="text-lg font-semibold mb-3">Recent Leads</h2>
        <div class="space-y-2">
            @forelse ($recentLeads as $lead)
                <div class="flex items-center justify-between text-sm bg-slate-50 rounded-lg px-3 py-2 border border-slate-100">
                    <div>
                        <div class="font-semibold text-slate-900">{{ $lead->name }}</div>
                        <div class="text-slate-500">{{ $lead->status }} • {{ $lead->created_at->format('M d') }}</div>
                    </div>
                    <a href="{{ route('admin.leads.edit', $lead) }}" class="text-sky-600 font-semibold">View</a>
                </div>
            @empty
                <p class="text-slate-500 text-sm">No leads yet.</p>
            @endforelse
        </div>
    </div>
</div>

<div class="card p-4 rounded-xl">
    <h2 class="text-lg font-semibold mb-3">Popular Blog Posts</h2>
    <div class="grid md:grid-cols-3 gap-3 text-sm">
        @forelse ($topPosts as $post)
            <div class="border border-slate-100 rounded p-3 bg-slate-50">
                <div class="font-semibold text-slate-900">{{ $post->title }}</div>
                <div class="text-slate-500">Views: {{ $post->view_count }}</div>
            </div>
        @empty
            <p class="text-slate-500">No posts yet.</p>
        @endforelse
    </div>
</div>

{{-- Content & SEO publishing workspace (match provided design) --}}
<div class="card p-0 overflow-hidden">
    <div class="bg-sky-600 text-white px-5 py-3 text-lg font-semibold">Add New Post</div>
    <div class="p-5 space-y-4">
        <form method="GET" action="{{ route('admin.blog-posts.create') }}" class="space-y-4">
            <div>
                <label class="block text-base font-semibold text-slate-800 mb-1">Meta Title</label>
                <input type="text" name="seo_title" placeholder="Enter Meta Title" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-800 mb-1">Meta Description</label>
                <input type="text" name="meta_description" placeholder="Enter Meta Description" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-800 mb-1">Page Title</label>
                <input type="text" name="title" placeholder="Enter Keyword Title" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-800 mb-1">Image Alt Text</label>
                <input type="text" name="alt" placeholder="Enter Image Alt Text" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-800 mb-1">Heading 2</label>
                <input type="text" name="h2" placeholder="Enter Heading 2" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-800 mb-1">Type</label>
                <select name="type" class="w-full bg-white border border-slate-200 rounded px-3 py-2 text-slate-900">
                    <option value="post">Post</option>
                    <option value="page">Page</option>
                </select>
            </div>
            <div>
                <label class="block text-base font-semibold text-slate-800 mb-1">Page Description</label>
                <div class="border border-slate-200 rounded-lg overflow-hidden bg-white">
                    <div class="px-3 py-2 text-sm text-slate-500 border-b border-slate-200">Rich text editor placeholder</div>
                    <textarea rows="6" placeholder="Write or paste your content..." class="w-full border-0 px-3 py-3 text-slate-900 focus:ring-0"></textarea>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <button type="submit" class="px-5 py-2 rounded bg-sky-600 text-white font-semibold hover:bg-sky-500">Open Editor</button>
                <a href="{{ route('admin.blog-posts.index') }}" class="px-5 py-2 rounded border border-slate-200 text-slate-700 font-semibold hover:bg-slate-50">Manage Posts</a>
            </div>
        </form>
    </div>
</div>
@endsection
