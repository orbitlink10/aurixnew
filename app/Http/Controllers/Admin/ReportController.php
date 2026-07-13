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
        $driver = DB::connection()->getDriverName();

        $monthSql = match ($driver) {
            'mysql' => "DATE_FORMAT(issued_at, '%Y-%m')",
            'pgsql' => "TO_CHAR(issued_at, 'YYYY-MM')",
            'sqlsrv' => "FORMAT(issued_at, 'yyyy-MM')",
            default => "strftime('%Y-%m', issued_at)",
        };

        $salesByMonth = Invoice::selectRaw("{$monthSql} as month, sum(total_amount) as total")
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
