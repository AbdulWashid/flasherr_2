<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\PaymentDetail;

class BuyController extends Controller
{
    public function salesIndex(Request $request)
    {
        $sales = Sale::with('saleRequest')->where('display_status', true)->where('status', '=', 'pending')->latest()->paginate(9);
        return view('user.buy', compact('sales'));
    }

    /**
     * Display the details of a single sale (optional, but good for a full flow).
     * You would need a corresponding route and blade view for this.
     *
     * @param  \App\Models\Sale  $sale
     * @return \Illuminate\View\View
     */
    public function showSaleDetails(Sale $sale)
    {
        if (!$sale->display_status || $sale->status != 'pending') {
            abort(404);
        }
        $sale->load('saleRequest');
        $paymentDetail = PaymentDetail::findOrFail(1);
        // dd($sale->toArray());
        return view('user.showDetails', compact('sale', 'paymentDetail'));
    }
}
