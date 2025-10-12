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
    public function store_old(Request $request)
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
    public function store(Request $request)
    {
        // dd($request->toArray());
        $sale = Sale::findOrFail($request->input('sale_id'));

        // 1. Validate all incoming data, including files
        $validatedData = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'address' => 'required|string|max:1000',
            'network_type' => ['required', 'string', Rule::in(['trc20', 'bep20', 'erc20'])],
            'wallet_address' => 'required|string|max:255',
            'quantity' => ['required', 'numeric', 'min:0.00000001', 'max:' . $sale->quantity],
            'document' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'photo' => 'required|file|mimes:jpg,jpeg,png|max:2048',
            'address_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $filePaths = [];

        try {
            // 2. Handle file uploads and store their paths
            if ($request->hasFile('document')) {
                $filePaths['document_path'] = $request->file('document')->store('buy_documents/ids', 'public');
            }
            if ($request->hasFile('photo')) {
                $filePaths['photo_path'] = $request->file('photo')->store('buy_documents/photos', 'public');
            }
            if ($request->hasFile('address_proof')) {
                $filePaths['address_proof_path'] = $request->file('address_proof')->store('buy_documents/proofs', 'public');
            }

            // 3. Merge validated text data with file paths
            $dataToCreate = array_merge($validatedData, $filePaths);

            // 4. Create the new buy request
            BuyRequest::create($dataToCreate);

            // Show a success message
            Alert::success('Success!', 'Your purchase request has been submitted successfully!');

            return redirect()->route('buy'); // Redirect to the main buy page or a success page
        } catch (\Exception $e) {
            Log::error('Buy Request Submission Failed: ' . $e->getMessage());
            Alert::error('Submission Failed', 'Something went wrong. Please try again.');
            return redirect()->back()->withInput();
        }
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
