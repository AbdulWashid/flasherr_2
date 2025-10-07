<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use RealRashid\SweetAlert\Facades\Alert;

class BuyController extends Controller
{
    public function salesIndex(Request $request)
    {
        // Fetch sales that are explicitly marked for display on the site,
        // are not cancelled, and are either 'pending' or 'sold' (as per your admin logic)
        $sales = Sale::with('saleRequest') // Eager load the related SaleRequest
            ->where('display_status', true)
            ->where('status', '!=', 'cancelled') // Ensure cancelled sales are not shown
            ->latest() // Order by newest first
            ->paginate(9); // Paginate for a grid layout (e.g., 3 columns x 3 rows per page)

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
        // Only show details if the sale is meant for public display
        if (!$sale->display_status || $sale->status == 'cancelled') {
            abort(404); // Or redirect with an error message
        }
        $sale->load('saleRequest');
        return view('user.showDetails', compact('sale'));
    }
}
