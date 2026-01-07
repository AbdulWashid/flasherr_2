<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_sale_requests' => 12,
            'total_buy_requests' => 13,
            'total_sale_adds' => 14,
            'today_messages' => 15,
        ];
        return view('admin.index', compact('data'));
    }
}
