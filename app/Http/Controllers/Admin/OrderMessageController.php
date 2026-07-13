<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderMessage;
use Illuminate\Http\Request;

class OrderMessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:manage_messages');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Order $order)
    {
        $data = $request->validate([
            'message' => ['required', 'string'],
        ]);

        $order->messages()->create([
            'message' => $data['message'],
            'user_id' => auth()->id(),
        ]);

        return back()->with('success', 'Message added.');
    }
}
