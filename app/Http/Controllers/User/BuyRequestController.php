<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuyRequest;
use App\Models\Sale;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;

class BuyRequestController extends Controller
{
    public function store(Request $request)
    {
        $sale = Sale::findOrFail($request->input('sale_id'));

        $validatedData = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'wallet_address' => 'required|string|max:255',
            'quantity' => ['required', 'numeric', 'min:0.00000001', 'max:' . $sale->quantity],
        ]);

        // Create the new buy request
        BuyRequest::create($validatedData);

        // Show a success toast message
        Alert::toast('Your purchase request has been submitted successfully!', 'success');

        // Redirect back to the same page
        return redirect()->back();
    }

    /**
     * Display a listing of all buy requests in the admin panel.
     */
    public function buyRequests(Request $request)
    {
        $query = BuyRequest::with('sale.saleRequest'); // Eager load nested relationships

        // Search functionality
        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)->orWhere('phone_number', 'like', $searchTerm)->orWhere('wallet_address', 'like', $searchTerm);
            });
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $buyRequests = $query->latest()->paginate(10)->withQueryString();

        return view('admin.buy.index', compact('buyRequests'));
    }

    /**
     * Update the status of a buy request via AJAX.
     */
    public function updateStatus(Request $request, BuyRequest $buyRequest)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'completed', 'rejected'])],
        ]);

        $buyRequest->update($validated);

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    /**
     * Remove the specified buy request from storage.
     */
    public function destroy(BuyRequest $buyRequest)
    {
        $buyRequest->delete();
        Alert::toast('Buy request deleted successfully.', 'success');
        return redirect()->route('buy.index');
    }
}
