@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-3">
    <h2 class="text-lg font-semibold text-white">Order #{{ $order->id }}</h2>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.orders.edit', $order) }}" class="px-3 py-1 bg-slate-800 border border-slate-700 rounded text-sm">Edit</a>
        <a href="{{ route('admin.orders.index') }}" class="text-sky-400 text-sm">Back to orders</a>
    </div>
</div>

<div class="grid md:grid-cols-3 gap-4">
    <div class="card p-4 rounded-xl md:col-span-2 space-y-3">
        <div class="flex justify-between">
            <div>
                <div class="text-slate-400 text-sm">Customer</div>
                <div class="font-semibold text-white">{{ $order->customer_name }}</div>
                <div class="text-slate-400 text-sm">{{ $order->customer_email }} | {{ $order->customer_phone }}</div>
            </div>
            <div class="text-right">
                <div class="text-slate-400 text-sm">Status</div>
                <div class="font-semibold capitalize">{{ str_replace('_',' ',$order->status) }}</div>
                <div class="text-slate-400 text-sm">Due {{ $order->due_date ?? '—' }}</div>
            </div>
        </div>

        <div>
            <div class="text-slate-400 text-sm mb-1">Line Items</div>
            <div class="border border-slate-800 rounded">
                <table class="w-full text-sm">
                    <thead class="text-slate-400">
                        <tr>
                            <th class="text-left py-2 px-3">Description</th>
                            <th class="text-right py-2 px-3">Qty</th>
                            <th class="text-right py-2 px-3">Price</th>
                            <th class="text-right py-2 px-3">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order->items as $item)
                            <tr class="border-t border-slate-800">
                                <td class="py-2 px-3">{{ $item->description }}</td>
                                <td class="py-2 px-3 text-right">{{ $item->quantity }}</td>
                                <td class="py-2 px-3 text-right">${{ number_format($item->unit_price, 2) }}</td>
                                <td class="py-2 px-3 text-right">${{ number_format($item->line_total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="flex justify-end gap-6 text-sm">
            <div>Subtotal: ${{ number_format($order->subtotal, 2) }}</div>
            <div>Discount: ${{ number_format($order->discount_amount, 2) }}</div>
            <div>Tax: ${{ number_format($order->tax_amount, 2) }}</div>
            <div class="font-semibold text-white">Total: ${{ number_format($order->total, 2) }}</div>
        </div>

        <div>
            <div class="text-slate-400 text-sm mb-1">Status Workflow</div>
            <form method="POST" action="{{ route('admin.orders.status', $order) }}" class="flex items-center gap-2 text-sm">
                @csrf
                <select name="status" class="bg-slate-800 border border-slate-700 rounded px-2 py-1 text-white">
                    @foreach ($statuses as $status)
                        <option value="{{ $status }}" @selected($order->status === $status)>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
                    @endforeach
                </select>
                <input type="text" name="note" placeholder="Note" class="bg-slate-800 border border-slate-700 rounded px-2 py-1 text-white flex-1">
                <button class="px-3 py-1 bg-sky-500 hover:bg-sky-400 text-slate-900 rounded">Update</button>
            </form>
            <div class="mt-2 space-y-1 text-xs text-slate-400">
                @foreach ($order->statusLogs as $log)
                    <div>{{ $log->created_at->format('Y-m-d H:i') }} • {{ $log->from_status ?? '—' }} → {{ $log->to_status }} • {{ $log->note }}</div>
                @endforeach
            </div>
        </div>
    </div>

    <div class="space-y-4">
        <div class="card p-4 rounded-xl">
            <h3 class="text-white font-semibold mb-2">Messages</h3>
            <form method="POST" action="{{ route('admin.orders.messages.store', $order) }}" class="space-y-2">
                @csrf
                <textarea name="message" rows="2" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white" placeholder="Add a note"></textarea>
                <button class="bg-slate-800 border border-slate-700 px-3 py-1 rounded text-sm">Send</button>
            </form>
            <div class="mt-2 text-sm space-y-2">
                @foreach ($order->messages as $message)
                    <div class="border border-slate-800 rounded p-2">
                        <div class="text-slate-400 text-xs">{{ $message->created_at->format('Y-m-d H:i') }} • {{ $message->user->name ?? 'System' }}</div>
                        <div>{{ $message->message }}</div>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card p-4 rounded-xl">
            <h3 class="text-white font-semibold mb-2">Files</h3>
            <form method="POST" action="{{ route('admin.orders.files.store', $order) }}" enctype="multipart/form-data" class="space-y-2">
                @csrf
                <input type="file" name="file" class="w-full text-sm text-white">
                <button class="bg-slate-800 border border-slate-700 px-3 py-1 rounded text-sm">Upload</button>
            </form>
            <div class="mt-2 text-sm space-y-1">
                @foreach ($order->files as $file)
                    <div class="flex justify-between items-center border border-slate-800 rounded px-2 py-1">
                        <span>{{ $file->original_name }}</span>
                        <span class="text-slate-400 text-xs">{{ number_format($file->size / 1024, 1) }} KB</span>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="card p-4 rounded-xl">
            <h3 class="text-white font-semibold mb-2">Invoice</h3>
            @if ($order->invoice)
                <div class="text-sm">
                    <div>Number: {{ $order->invoice->number }}</div>
                    <div>Status: {{ $order->invoice->status }}</div>
                    <div>Total: ${{ number_format($order->invoice->total_amount, 2) }}</div>
                    <a href="{{ route('admin.invoices.show', $order->invoice) }}" class="text-sky-400 text-sm mt-2 inline-block">View invoice</a>
                </div>
            @else
                <p class="text-slate-400 text-sm mb-2">No invoice yet.</p>
                <a href="{{ route('admin.invoices.create', ['order_id' => $order->id]) }}" class="px-3 py-1 bg-sky-500 text-slate-900 rounded text-sm">Create Invoice</a>
            @endif
        </div>
    </div>
</div>
@endsection
