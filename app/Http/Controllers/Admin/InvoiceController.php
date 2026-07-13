<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_invoices');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = Invoice::with('order')->orderByDesc('created_at')->paginate(20);

        return view('admin.invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.invoices.create', [
            'orders' => Order::orderByDesc('created_at')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'number' => ['nullable', 'string', 'max:100', 'unique:invoices,number'],
            'status' => ['required', 'string', 'max:50'],
            'amount' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'issued_at' => ['nullable', 'date'],
            'paid_at' => ['nullable', 'date'],
            'etims_payload' => ['nullable', 'array'],
            'etims_receipt_number' => ['nullable', 'string', 'max:255'],
        ]);

        $data['number'] = $data['number'] ?? 'INV-'.now()->format('Ymd').'-'.Str::random(4);

        Invoice::create($data);

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Invoice $invoice)
    {
        $invoice->load('order');

        return view('admin.invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Invoice $invoice)
    {
        return view('admin.invoices.create', [
            'invoice' => $invoice,
            'orders' => Order::orderByDesc('created_at')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Invoice $invoice)
    {
        $data = $request->validate([
            'order_id' => ['required', 'exists:orders,id'],
            'number' => ['required', 'string', 'max:100', 'unique:invoices,number,'.$invoice->id],
            'status' => ['required', 'string', 'max:50'],
            'amount' => ['required', 'numeric', 'min:0'],
            'tax_amount' => ['nullable', 'numeric', 'min:0'],
            'total_amount' => ['required', 'numeric', 'min:0'],
            'due_date' => ['nullable', 'date'],
            'issued_at' => ['nullable', 'date'],
            'paid_at' => ['nullable', 'date'],
            'etims_payload' => ['nullable', 'array'],
            'etims_receipt_number' => ['nullable', 'string', 'max:255'],
        ]);

        $invoice->update($data);

        return redirect()->route('admin.invoices.show', $invoice)->with('success', 'Invoice updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return redirect()->route('admin.invoices.index')->with('success', 'Invoice removed.');
    }
}
