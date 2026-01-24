@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-3">
    <h2 class="text-lg font-semibold text-white">{{ isset($order) ? 'Edit Order' : 'Create Order' }}</h2>
    <a href="{{ route('admin.orders.index') }}" class="text-sky-400 text-sm">Back to list</a>
</div>

<div class="card p-4 rounded-xl">
    <form method="POST" action="{{ isset($order) ? route('admin.orders.update', $order) : route('admin.orders.store') }}">
        @csrf
        @isset($order)
            @method('PUT')
        @endisset
        <div class="grid md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm mb-1">Customer Name</label>
                <input type="text" name="customer_name" value="{{ old('customer_name', $order->customer_name ?? '') }}" required class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Customer Email</label>
                <input type="email" name="customer_email" value="{{ old('customer_email', $order->customer_email ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Customer Phone</label>
                <input type="text" name="customer_phone" value="{{ old('customer_phone', $order->customer_phone ?? '') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Lead</label>
                <select name="lead_id" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                    <option value="">--</option>
                    @foreach ($leads as $lead)
                        <option value="{{ $lead->id }}" @selected(old('lead_id', $order->lead_id ?? '') == $lead->id)>{{ $lead->name }} ({{ $lead->status }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Package</label>
                <select name="package_id" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                    <option value="">Custom</option>
                    @foreach ($packages as $package)
                        <option value="{{ $package->id }}" @selected(old('package_id', $order->package_id ?? '') == $package->id)>{{ $package->name }} - ${{ number_format($package->price,2) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Currency</label>
                <input type="text" name="currency" value="{{ old('currency', $order->currency ?? 'USD') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Status</label>
                <select name="status" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                    @foreach (\App\Models\Order::STATUSES as $status)
                        <option value="{{ $status }}" @selected(old('status', $order->status ?? 'draft') == $status)>{{ ucfirst(str_replace('_',' ',$status)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm mb-1">Discount</label>
                <input type="number" step="0.01" name="discount_amount" value="{{ old('discount_amount', $order->discount_amount ?? 0) }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Tax</label>
                <input type="number" step="0.01" name="tax_amount" value="{{ old('tax_amount', $order->tax_amount ?? 0) }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div>
                <label class="block text-sm mb-1">Due Date</label>
                <input type="date" name="due_date" value="{{ old('due_date', isset($order->due_date) ? $order->due_date->format('Y-m-d') : '') }}" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            </div>
            <div class="md:col-span-3">
                <label class="block text-sm mb-1">Notes</label>
                <textarea name="notes" rows="2" class="w-full bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">{{ old('notes', $order->notes ?? '') }}</textarea>
            </div>
        </div>

        <div class="mt-6">
            <div class="flex items-center justify-between mb-2">
                <h3 class="text-white font-semibold">Line Items</h3>
                <button type="button" onclick="addItemRow()" class="px-3 py-1 bg-slate-800 border border-slate-700 rounded text-sm">Add item</button>
            </div>
            <div id="items">
                @php
                    $existingItems = old('item_description') ? collect(old('item_description'))->map(function($desc, $i) {
                        return [
                            'description' => $desc,
                            'quantity' => old('item_quantity')[$i] ?? 1,
                            'price' => old('item_price')[$i] ?? 0,
                            'service_id' => old('item_service')[$i] ?? null,
                            'package_id' => old('item_package')[$i] ?? null,
                        ];
                    }) : (isset($order) ? $order->items : collect([['description'=>'','quantity'=>1,'unit_price'=>0]]));
                @endphp
                @foreach ($existingItems as $index => $item)
                    <div class="grid md:grid-cols-5 gap-2 mb-2 item-row">
                        <input type="text" name="item_description[]" placeholder="Description" value="{{ $item['description'] ?? $item->description ?? '' }}" class="md:col-span-2 bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                        <input type="number" step="1" min="1" name="item_quantity[]" value="{{ $item['quantity'] ?? $item->quantity ?? 1 }}" class="bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                        <input type="number" step="0.01" min="0" name="item_price[]" value="{{ $item['price'] ?? $item->unit_price ?? 0 }}" class="bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                        <select name="item_service[]" class="bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                            <option value="">Service</option>
                            @foreach ($services as $service)
                                <option value="{{ $service->id }}" @selected(($item['service_id'] ?? $item->service_id ?? '') == $service->id)>{{ $service->name }}</option>
                            @endforeach
                        </select>
                        <select name="item_package[]" class="bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                            <option value="">Package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}" @selected(($item['package_id'] ?? $item->package_id ?? '') == $package->id)>{{ $package->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6 flex justify-end">
            <button class="bg-sky-500 hover:bg-sky-400 text-slate-900 font-semibold px-5 py-2 rounded">Save Order</button>
        </div>
    </form>
</div>

<script>
    function addItemRow() {
        const container = document.getElementById('items');
        const div = document.createElement('div');
        div.className = 'grid md:grid-cols-5 gap-2 mb-2 item-row';
        div.innerHTML = `
            <input type="text" name="item_description[]" placeholder="Description" class="md:col-span-2 bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            <input type="number" step="1" min="1" name="item_quantity[]" value="1" class="bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            <input type="number" step="0.01" min="0" name="item_price[]" value="0" class="bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
            <select name="item_service[]" class="bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                <option value="">Service</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
            <select name="item_package[]" class="bg-slate-800 border border-slate-700 rounded px-3 py-2 text-white">
                <option value="">Package</option>
                @foreach ($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                @endforeach
            </select>
        `;
        container.appendChild(div);
    }
</script>
@endsection
