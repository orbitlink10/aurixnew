<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusLog;
use App\Models\Package;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_orders');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Order::with(['package', 'lead'])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $orders = $query->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.orders.create', [
            'packages' => Package::orderBy('name')->get(),
            'services' => Service::orderBy('name')->get(),
            'leads' => Lead::orderByDesc('created_at')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'lead_id' => ['nullable', 'exists:leads,id'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:3'],
            'due_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'item_description' => ['array'],
            'item_quantity' => ['array'],
            'item_price' => ['array'],
            'item_service' => ['array'],
            'item_package' => ['array'],
        ]);

        $items = $this->buildItems($request);
        $totals = $this->calculateTotals($items, $data['discount_amount'] ?? 0, $data['tax_amount'] ?? 0);

        DB::transaction(function () use ($data, $items, $totals) {
            $order = Order::create([
                'lead_id' => $data['lead_id'] ?? null,
                'package_id' => $data['package_id'] ?? null,
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'] ?? null,
                'customer_phone' => $data['customer_phone'] ?? null,
                'status' => $data['status'],
                'subtotal' => $totals['subtotal'],
                'discount_amount' => $data['discount_amount'] ?? 0,
                'tax_amount' => $data['tax_amount'] ?? 0,
                'total' => $totals['total'],
                'currency' => $data['currency'],
                'due_date' => $data['due_date'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            foreach ($items as $item) {
                $order->items()->create($item);
            }

            OrderStatusLog::create([
                'order_id' => $order->id,
                'user_id' => auth()->id(),
                'from_status' => null,
                'to_status' => $order->status,
                'note' => 'Order created',
            ]);
        });

        return redirect()->route('admin.orders.index')->with('success', 'Order created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->load(['items.service', 'items.package', 'messages.user', 'files.user', 'statusLogs', 'invoice']);

        return view('admin.orders.show', [
            'order' => $order,
            'statuses' => Order::STATUSES,
            'packages' => Package::orderBy('name')->get(),
            'services' => Service::orderBy('name')->get(),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        $order->load('items');

        return view('admin.orders.create', [
            'order' => $order,
            'packages' => Package::orderBy('name')->get(),
            'services' => Service::orderBy('name')->get(),
            'leads' => Lead::orderByDesc('created_at')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Order $order)
    {
        $data = $request->validate([
            'lead_id' => ['nullable', 'exists:leads,id'],
            'package_id' => ['nullable', 'exists:packages,id'],
            'customer_name' => ['required', 'string', 'max:255'],
            'customer_email' => ['nullable', 'email'],
            'customer_phone' => ['nullable', 'string', 'max:50'],
            'status' => ['required', 'string', 'max:50'],
            'discount_amount' => ['nullable', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'max:3'],
            'due_date' => ['nullable', 'date'],
            'notes' => ['nullable', 'string'],
            'item_description' => ['array'],
            'item_quantity' => ['array'],
            'item_price' => ['array'],
            'item_service' => ['array'],
            'item_package' => ['array'],
        ]);

        $items = $this->buildItems($request);
        $totals = $this->calculateTotals($items, $data['discount_amount'] ?? 0, $data['tax_amount'] ?? 0);

        DB::transaction(function () use ($data, $items, $totals, $order) {
            $order->update([
                'lead_id' => $data['lead_id'] ?? null,
                'package_id' => $data['package_id'] ?? null,
                'customer_name' => $data['customer_name'],
                'customer_email' => $data['customer_email'] ?? null,
                'customer_phone' => $data['customer_phone'] ?? null,
                'status' => $data['status'],
                'subtotal' => $totals['subtotal'],
                'discount_amount' => $data['discount_amount'] ?? 0,
                'tax_amount' => $data['tax_amount'] ?? 0,
                'total' => $totals['total'],
                'currency' => $data['currency'],
                'due_date' => $data['due_date'] ?? null,
                'notes' => $data['notes'] ?? null,
            ]);

            $order->items()->delete();
            foreach ($items as $item) {
                $order->items()->create($item);
            }
        });

        return redirect()->route('admin.orders.show', $order)->with('success', 'Order updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Order removed.');
    }

    public function updateStatus(Request $request, Order $order)
    {
        $data = $request->validate([
            'status' => ['required', 'string', 'max:50'],
            'note' => ['nullable', 'string'],
        ]);

        $previous = $order->status;
        $order->update(['status' => $data['status']]);

        OrderStatusLog::create([
            'order_id' => $order->id,
            'user_id' => auth()->id(),
            'from_status' => $previous,
            'to_status' => $data['status'],
            'note' => $data['note'] ?? null,
        ]);

        return back()->with('success', 'Status updated.');
    }

    private function buildItems(Request $request): array
    {
        $descriptions = $request->input('item_description', []);
        $quantities = $request->input('item_quantity', []);
        $prices = $request->input('item_price', []);
        $services = $request->input('item_service', []);
        $packages = $request->input('item_package', []);

        $items = [];

        foreach ($descriptions as $index => $description) {
            $description = trim((string) $description);
            if ($description === '') {
                continue;
            }

            $quantity = max(1, (int) ($quantities[$index] ?? 1));
            $unitPrice = (float) ($prices[$index] ?? 0);
            $lineTotal = $quantity * $unitPrice;

            $items[] = [
                'description' => $description,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'line_total' => $lineTotal,
                'service_id' => $services[$index] ?? null,
                'package_id' => $packages[$index] ?? null,
            ];
        }

        if (empty($items) && $request->filled('package_id')) {
            $package = Package::find($request->integer('package_id'));
            if ($package) {
                $items[] = [
                    'description' => $package->name,
                    'quantity' => 1,
                    'unit_price' => (float) $package->price,
                    'line_total' => (float) $package->price,
                    'service_id' => $package->service_id,
                    'package_id' => $package->id,
                ];
            }
        }

        return $items;
    }

    private function calculateTotals(array $items, float $discount, float $tax): array
    {
        $subtotal = collect($items)->sum('line_total');
        $subtotal = round($subtotal, 2);
        $discount = round($discount, 2);
        $tax = round($tax, 2);

        $total = max(0, $subtotal - $discount + $tax);

        return compact('subtotal', 'total');
    }
}
