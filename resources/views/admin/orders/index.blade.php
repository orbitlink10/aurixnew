@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-3">
    <h2 class="text-lg font-semibold text-white">Orders</h2>
    <a href="{{ route('admin.orders.create') }}" class="bg-sky-500 hover:bg-sky-400 text-slate-900 px-3 py-2 rounded">New Order</a>
</div>

<div class="card p-4 rounded-xl">
    <form method="GET" class="flex items-center gap-3 text-sm mb-3">
        <label class="text-slate-400">Status</label>
        <select name="status" class="bg-slate-800 border border-slate-700 rounded px-2 py-1 text-white">
            <option value="">All</option>
            @foreach (\App\Models\Order::STATUSES as $status)
                <option value="{{ $status }}" @selected(request('status') === $status)>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
            @endforeach
        </select>
        <button class="px-3 py-1 bg-slate-800 border border-slate-700 rounded">Filter</button>
    </form>

    <div class="overflow-x-auto">
        <table class="min-w-full text-sm">
            <thead class="text-slate-400">
                <tr>
                    <th class="text-left py-2">Customer</th>
                    <th class="text-left py-2">Status</th>
                    <th class="text-left py-2">Total</th>
                    <th class="text-left py-2">Due</th>
                    <th class="text-left py-2">Created</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                    <tr class="border-t border-slate-800">
                        <td class="py-2">
                            <div class="font-semibold">{{ $order->customer_name }}</div>
                            <div class="text-slate-400">{{ $order->customer_email }}</div>
                        </td>
                        <td class="py-2 capitalize">{{ str_replace('_',' ',$order->status) }}</td>
                        <td class="py-2">${{ number_format($order->total, 2) }}</td>
                        <td class="py-2">{{ $order->due_date ?? '—' }}</td>
                        <td class="py-2">{{ $order->created_at->format('Y-m-d') }}</td>
                        <td class="py-2 text-right space-x-2">
                            <a class="text-sky-400" href="{{ route('admin.orders.show', $order) }}">Open</a>
                            <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="text-rose-300" onclick="return confirm('Delete this order?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td class="py-3 text-slate-500" colspan="6">No orders yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="mt-3">{{ $orders->links() }}</div>
</div>
@endsection
