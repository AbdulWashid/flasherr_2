<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'totalenquiries' => 12,
            'todayenquiries' => 13,
            'totalproducts' => 14,
            'totallots' => 15,
        ];
        return view('admin.index', compact('data'));
    }
}
