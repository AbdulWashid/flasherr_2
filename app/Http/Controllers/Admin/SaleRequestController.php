<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\SaleRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;

class SaleRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = SaleRequest::query();

        if ($request->filled('search')) {
            $searchTerm = '%' . $request->search . '%';
            $query->where(function ($q) use ($searchTerm) {
                $q->where('name', 'like', $searchTerm)->orWhere('phone_number', 'like', 'searchTerm')->orWhere('wallet_address', 'like', $searchTerm);
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $saleRequests = $query->orderByRaw('is_read ASC')->latest()->paginate(10)->withQueryString();

        return view('admin.sale-request.index', compact('saleRequests'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $sale = SaleRequest::findOrFail($id);
        if (!$sale->is_read) {
            $sale->update(['is_read' => 1]);
        }
        return view('admin.sale-request.show', ['request' => $sale]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $sale = SaleRequest::findOrFail($id);
        if (!$sale->is_read) {
            $sale->update(['is_read' => 1]);
        }
        return view('admin.sale-request.edit', ['request' => $sale]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $sale = SaleRequest::findOrFail($id);
        $validatedData = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-()]{7,20}$/'],
            'whatsapp_number' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9\s\-()]{7,20}$/'],
            'wallet_address' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'numeric', 'min:0'],
            'min_quantity' => ['nullable', 'numeric', 'min:0'],
            'status' => ['required', 'string', 'in:pending,approved,rejected'],
            'rate' => ['required', 'numeric', 'min:1'],
        ]);

        $sale->update($validatedData);

        Alert::toast('Sale request updated successfully.', 'success');
        return redirect()->route('admin.sale-request.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $sale = SaleRequest::findOrFail($id);
            $documents = json_decode($sale->documents_paths, true);

            if (is_array($documents) && !empty($documents)) {
                foreach ($documents as $path) {
                    Storage::disk('public')->delete($path);
                }
            }
            $sale->delete();

            Alert::toast('Sale request has been deleted.', 'success');
        } catch (\Exception $e) {
            Alert::toast('Failed to delete the sale request.', 'error');
        }

        return redirect()->route('admin.sale-request.index');
    }

    public function deleteDocument(Request $request, SaleRequest $sale)
    {
        $request->validate(['document_path' => 'required|string']);

        $pathToDelete = $request->input('document_path');

        $documents = is_array($sale->documents_paths) ? $sale->documents_paths : json_decode($sale->documents_paths, true) ?? [];

        if (in_array($pathToDelete, $documents)) {
            Storage::disk('public')->delete($pathToDelete);

            $newDocuments = array_values(
                Arr::where($documents, function ($value) use ($pathToDelete) {
                    return $value !== $pathToDelete;
                }),
            );

            $sale->documents_paths = $newDocuments;
            $sale->save();

            Alert::toast('Document has been deleted.', 'success');
        } else {
            Alert::toast('Document not found.', 'error');
        }

        return back();
    }
    public function updateStatus(Request $request, SaleRequest $sale)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'approved', 'rejected'])],
        ]);

        $sale->status = $validated['status'];
        $sale->save();

        return response()->json(['message' => 'Status has been updated successfully.']);
    }
}
