<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use RealRashid\SweetAlert\Facades\Alert;

class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Contact::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query
                ->where('first_name', 'like', "%{$search}%")
                ->orWhere('last_name', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%")
                ->orWhere('phone_number', 'like', "%{$search}%");
        }

        $contacts = $query->latest()->paginate(10);

        return view('admin.contacts.index', compact('contacts'));
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
        try {
            $validated = $request->validate([
                'first_name' => 'required|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'email' => 'nullable|email|max:255',
                'phone_number' => 'nullable|string|max:20',
                'message' => 'nullable|string|max:500',
            ]);

            $contact = Contact::create($validated);

            return response()->json([
                'status' => 1,
                'msg' => 'Your message has been sent successfully!',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Return validation errors
            return response()->json([
                'status' => 0,
                'msg' => $e->validator->errors()->first(), // show first error
            ]);
        } catch (\Exception $e) {
            // Handle unexpected errors
            return response()->json([
                'status' => 0,
                'msg' => 'Something went wrong! Please try again later.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.show', compact('contact'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $contact = Contact::findOrFail($id);
        return view('admin.contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $contact = Contact::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone_number' => 'nullable|string|max:20',
            'message' => 'nullable|string|max:500',
        ]);

        $contact->update($request->all());

        Alert::success('Updated!', 'Contact updated successfully.');
        return redirect()->route('contact.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $contact = Contact::findOrFail($id);
        $contact->delete();

        Alert::success('Deleted!', 'Contact deleted successfully.');
        return redirect()->route('contact.index');
    }
}
