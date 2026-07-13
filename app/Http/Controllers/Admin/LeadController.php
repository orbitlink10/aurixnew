<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;

class LeadController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_leads');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Lead::with(['service', 'assignee'])->orderByDesc('created_at');

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $leads = $query->paginate(20);
        $services = Service::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.leads.index', compact('leads', 'services', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return redirect()->route('admin.leads.index');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'service_id' => ['nullable', 'exists:services,id'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'contacted_at' => ['nullable', 'date'],
            'quoted_at' => ['nullable', 'date'],
            'closed_at' => ['nullable', 'date'],
        ]);

        Lead::create($data);

        return redirect()->route('admin.leads.index')->with('success', 'Lead captured.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lead $lead)
    {
        return redirect()->route('admin.leads.edit', $lead);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lead $lead)
    {
        $leads = Lead::with(['service', 'assignee'])->orderByDesc('created_at')->paginate(20);
        $services = Service::orderBy('name')->get();
        $users = User::orderBy('name')->get();

        return view('admin.leads.index', [
            'leads' => $leads,
            'services' => $services,
            'users' => $users,
            'editing' => $lead,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Lead $lead)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string', 'max:50'],
            'service_id' => ['nullable', 'exists:services,id'],
            'budget' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'string', 'max:50'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'contacted_at' => ['nullable', 'date'],
            'quoted_at' => ['nullable', 'date'],
            'closed_at' => ['nullable', 'date'],
        ]);

        $lead->update($data);

        return redirect()->route('admin.leads.index')->with('success', 'Lead updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lead $lead)
    {
        $lead->delete();

        return redirect()->route('admin.leads.index')->with('success', 'Lead removed.');
    }
}
