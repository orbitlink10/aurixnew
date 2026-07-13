<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Package;
use App\Models\Order;
use App\Models\Lead;
use App\Models\BlogPost;
use App\Models\Invoice;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        $orderStats = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $leadStats = Lead::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.dashboard', [
            'serviceCount' => Service::count(),
            'packageCount' => Package::count(),
            'orderCount' => Order::count(),
            'invoiceCount' => Invoice::count(),
            'userCount' => User::count(),
            'enquiryCount' => Lead::count(),
            'recentOrderCount' => Order::where('created_at', '>=', now()->subDays(7))->count(),
            'newUserCount' => User::where('created_at', '>=', now()->subDays(30))->count(),
            'activeUserCount' => User::where('updated_at', '>=', now()->subDay())->count(),
            'orderStats' => $orderStats,
            'leadStats' => $leadStats,
            'recentOrders' => Order::latest()->take(5)->get(),
            'recentLeads' => Lead::latest()->take(5)->get(),
            'topPosts' => BlogPost::orderByDesc('view_count')->take(5)->get(),
            'paidRevenue' => Invoice::where('status', 'paid')->sum('total_amount'),
        ]);
    }
}
