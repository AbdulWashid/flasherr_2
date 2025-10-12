<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\SaleRequest;
use Illuminate\Support\Facades\Log;

class SaleController extends Controller
{
    public function index()
    {
        return view('user.sale');
    }
    public function store(Request $request)
    {
        // dd($request->toArray());
        // 1. Validate the request data (this remains the same)
        $validatedData = $request->validate(
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255'],
                'phone_number' => ['required', 'string', 'max:20', 'regex:/^\+?[0-9\s\-()]{7,20}$/'],
                'whatsapp_number' => ['nullable', 'string', 'max:20', 'regex:/^\+?[0-9\s\-()]{7,20}$/'],
                'wallet_address' => ['required', 'string', 'max:255'],
                'quantity' => ['required', 'numeric', 'min:10', 'max:100000000'],
                'documents' => ['nullable', 'array', 'max:5'],
                'documents.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            ],
            [
                'quantity.min' => 'The minimum selling quantity is 10 USDT.',
            ],
        );

        $documentsPaths = [];

        // 2. Handle document uploads
        if ($request->hasFile('documents')) {
            foreach ($request->file('documents') as $document) {
                try {
                    $path = $document->store('sale_documents', 'public');
                    $documentsPaths[] = $path;
                } catch (\Exception $e) {
                    Log::error('Document upload failed: ' . $e->getMessage());
                    // Use SweetAlert for the error message
                    Alert::error('Upload Failed', 'Failed to upload one or more documents. Please try again.');
                    return back()->withInput();
                }
            }
        }

        // 3. Create a new SaleRequest
        try {
            SaleRequest::create([
                'name' => $validatedData['name'],
                'phone_number' => $validatedData['phone_number'],
                'wallet_address' => $validatedData['wallet_address'],
                'email' => $validatedData['email'],
                'whatsapp_number' => $validatedData['whatsapp_number'] ?? null,
                'quantity' => $validatedData['quantity'],
                'ip_address' => request()->ip(),
                'documents_paths' => !empty($documentsPaths) ? json_encode($documentsPaths) : null,
                'status' => 'pending',
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to create sale request: ' . $e->getMessage());
            // Use SweetAlert for the error message
            Alert::error('Submission Failed', 'Something went wrong while submitting your request. Please try again.');
            return back()->withInput();
        }

        // 4. Redirect with a SweetAlert success message
        Alert::success('Success!', 'Your USDT sale request has been submitted successfully! We will contact you shortly.');
        return redirect()->route('sale');
    }
}
