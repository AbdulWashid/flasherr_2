<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentDetail;
use RealRashid\SweetAlert\Facades\Alert;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $payments = PaymentDetail::findOrFail(1);
        return view('admin.payment.index', compact('payments'));
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
    public function show(string $id) {}

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // 1. Validate the incoming request data
        $validatedData = $request->validate([
            'vpa' => 'required|string|max:255',
        ]);

        try {
            // 2. Find the single payment detail record
            $paymentDetail = PaymentDetail::findOrFail(1);

            // 3. Update the VPA attribute
            $paymentDetail->vpa = $validatedData['vpa'];
            $paymentDetail->save();

            // 4. Success alert and redirect
            Alert::success('Success!', 'Payment details (VPA) updated successfully.');
            return redirect()->route('admin.payment.index'); // Redirect back to the index page
        } catch (\Exception $e) {
            // 5. Error handling
            \Log::error('Payment Detail Update Failed: ' . $e->getMessage());
            Alert::error('Update Failed', 'Something went wrong while updating the VPA.');
            return redirect()->back()->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
