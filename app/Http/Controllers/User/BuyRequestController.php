<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BuyRequest;
use App\Models\Sale;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class BuyRequestController extends Controller
{
    public function store(Request $request)
    {
        $sale = Sale::findOrFail($request->input('sale_id'));

        $validatedData = $request->validate([
            'sale_id' => 'required|exists:sales,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'transaction_id' => 'required|string|max:255',
            'payment_proof' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'network_type' => ['required', 'string', Rule::in(['trc20', 'bep20', 'erc20', 'other'])],
            'wallet_address' => 'required|string|max:255',
            'quantity' => ['required', 'numeric', 'min:0.00000001', 'max:' . $sale->quantity],
        ]);

        try {
            if ($request->hasFile('payment_proof')) {
                $validatedData['payment_proof'] = $request->file('payment_proof')->store('buy_documents/payments', 'public');
            }

            BuyRequest::create($validatedData);

            Alert::success('Success!', 'Your purchase request has been submitted successfully!');
            return redirect()->route('buy');
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
        return redirect()->route('admin.buy-requests.index');
    }

    /**
     * Display the specified buy request.
     */
    public function show(BuyRequest $buyRequest)
    {
        // Eager load the relationships
        $buyRequest->load('sale.saleRequest');
        return view('admin.buy.show', compact('buyRequest'));
    }

    /**
     * Show the form for editing the specified buy request.
     */
    public function edit(BuyRequest $buyRequest)
    {
        return view('admin.buy.edit', compact('buyRequest'));
    }

    /**
     * Update the specified buy request in storage.
     */
    public function update(Request $request, BuyRequest $buyRequest)
    {
        // Load the related sale to validate max quantity
        $buyRequest->load('sale');

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'network_type' => ['required', 'string', Rule::in(['trc20', 'bep20', 'erc20'])],
            'wallet_address' => 'required|string|max:255',
            'quantity' => ['required', 'numeric', 'min:0.00000001', 'max:' . $buyRequest->sale->quantity],
        ]);

        try {
            // Update all the text-based fields
            $buyRequest->update($request->only(['name', 'email', 'phone_number', 'country', 'city', 'address', 'network_type', 'wallet_address', 'quantity']));

            // Handle Document Upload
            if ($request->hasFile('document')) {
                // Delete old file if it exists
                if ($buyRequest->document_path) {
                    Storage::disk('public')->delete($buyRequest->document_path);
                }
                // Store new file
                $buyRequest->document_path = $request->file('document')->store('buy_documents/ids', 'public');
            }

            // Handle Photo Upload
            if ($request->hasFile('photo')) {
                if ($buyRequest->photo_path) {
                    Storage::disk('public')->delete($buyRequest->photo_path);
                }
                $buyRequest->photo_path = $request->file('photo')->store('buy_documents/photos', 'public');
            }

            // Handle Address Proof Upload
            if ($request->hasFile('address_proof')) {
                if ($buyRequest->address_proof_path) {
                    Storage::disk('public')->delete($buyRequest->address_proof_path);
                }
                $buyRequest->address_proof_path = $request->file('address_proof')->store('buy_documents/proofs', 'public');
            }

            // Save the changes (for file paths)
            $buyRequest->save();

            Alert::success('Success!', 'Buy request updated successfully!');
            return redirect()->route('admin.buy-requests.index');
        } catch (\Exception $e) {
            Log::error('Buy Request Update Failed: ' . $e->getMessage());
            Alert::error('Update Failed', 'Something went wrong. Please try again.');
            return redirect()->back()->withInput();
        }
    }
}
