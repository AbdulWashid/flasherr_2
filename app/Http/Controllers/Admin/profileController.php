<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\User;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
            'cropped_image' => 'nullable|string',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->filled('cropped_image')) {
            // Delete the old image if it exists
            if ($user->image && Storage::disk('public')->exists($user->image)) {
                Storage::disk('public')->delete($user->image);
            }

            $imageData = $request->cropped_image;
            [$type, $imageData] = explode(';', $imageData);
            [, $imageData] = explode(',', $imageData);
            $imageData = base64_decode($imageData);

            $imageName = 'avatars/' . Str::random(20) . '.jpg';

            Storage::disk('public')->put($imageName, $imageData);

            $user->image = $imageName;
        }

        $user->save();

        // 2. Add the success alert to the session
        Alert::success('Profile Updated!', 'Your profile has been updated successfully.');

        return response()->json(['message' => 'Profile updated successfully!']);
    }
}
