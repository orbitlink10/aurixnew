<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\Invoice;
use App\Models\Lead;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view_reports');
    }

    public function index(Request $request)
    {
        $salesByMonth = Invoice::selectRaw("strftime('%Y-%m', issued_at) as month, sum(total_amount) as total")
            ->whereNotNull('issued_at')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $leadFunnel = Lead::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $orderStatus = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $conversionRate = 0;
        $won = $leadFunnel['won'] ?? 0;
        $totalLeads = $leadFunnel->sum();
        if ($totalLeads > 0) {
            $conversionRate = round(($won / $totalLeads) * 100, 2);
        }

        $popularPosts = BlogPost::orderByDesc('view_count')->take(5)->get();

        return view('admin.reports.index', [
            'salesByMonth' => $salesByMonth,
            'leadFunnel' => $leadFunnel,
            'orderStatus' => $orderStatus,
            'conversionRate' => $conversionRate,
            'popularPosts' => $popularPosts,
        ]);
    }
}
