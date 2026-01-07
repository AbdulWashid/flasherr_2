<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sale;
use App\Models\SaleRequest;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class SaleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Sale::query()->with('saleRequest');

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';

            $query->where(function ($q) use ($searchTerm) {
                $q->where('status', 'like', $searchTerm)->orWhereHas('saleRequest', function ($subQuery) use ($searchTerm) {
                    $subQuery->where('name', 'like', $searchTerm)->orWhere('phone_number', 'like', $searchTerm)->orWhere('wallet_address', 'like', $searchTerm);
                });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $sales = $query->latest()->paginate(10)->withQueryString();
        return view('admin.sale.index', compact('sales'));
    }

    /**
     * Show the form for creating a new resource.
     */

    public function create(SaleRequest $saleRequestFrom = null)
    {

        $saleRequests = SaleRequest::where('status', 'approved')->get();

        return view('admin.sale.create', [
            'saleRequests' => $saleRequests,
            'saleRequestFrom' => $saleRequestFrom,
        ]);
    }

    public function createFromRequest(SaleRequest $saleRequest)
    {
        return $this->create($saleRequest);
    }
    /**
     * Store a newly created resource in storage.
    */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'sale_request_id' => ['required', 'exists:sale_requests,id'],
            'quantity' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:pending,sold,cancelled',
            'price' => 'required|numeric|min:0',
            'is_verified' => 'required|boolean',
            'display_status' => 'required|boolean',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        Sale::create($validatedData);

        Alert::toast('Sale created successfully', 'success');
        return redirect()->route('admin.sale.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Sale $sale)
    {
        $sale->load('saleRequest');
        return view('admin.sale.show', compact('sale'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = Sale::findOrFail($id);
        $saleRequests = SaleRequest::where('status', 'approved')->get();
        return view('admin.sale.edit', compact('sale', 'saleRequests'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $validatedData = $request->validate([
            'sale_request_id' => 'required',
            'quantity' => 'required|numeric|min:0',
            'rate' => 'required|numeric|min:0',
            'status' => 'required|in:pending,sold,cancelled',
            'price' => 'required|numeric|min:0',
            'is_verified' => 'required|boolean',
            'display_status' => 'required|boolean',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
        ]);

        $sale->update($validatedData);

        Alert::toast('Sale updated successfully', 'success');

        return redirect()->route('admin.sale.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Sale::where('id', $id)->delete();
        Alert::toast('Sale deleted successfully', 'success');
        return redirect()->route('admin.sale.index');
    }

    public function updateStatus(Request $request, Sale $sale)
    {
        $request->validate([
            'status' => 'required|in:pending,sold,cancelled',
        ]);

        $sale->status = $request->status;
        $sale->save();

        return response()->json(['success' => true, 'message' => 'Sale status updated successfully.']);
    }

    /**
     * Update the display status via AJAX.
     */
    public function updateDisplayStatus(Request $request, Sale $sale)
    {
        $request->validate([
            'display_status' => 'required|boolean',
        ]);

        $sale->display_status = (bool) $request->display_status;
        $sale->save();

        return response()->json(['success' => true, 'message' => 'Display status updated successfully.']);
    }
}
