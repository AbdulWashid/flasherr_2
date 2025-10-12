<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Validation\ValidationException;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        DB::beginTransaction();

        try {
            $validatedData = $request->validate([
                'profile_name' => 'required|string|max:255',
                'profile_email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
                'password' => 'nullable|string|min:8',
                'cropped_image' => 'nullable|string',
            ]);

            if ($request->filled('cropped_image')) {
                $user->image = $this->handleProfileImage($request->cropped_image, $user->image);
            }

            $user->name = $validatedData['profile_name'];
            $user->email = $validatedData['profile_email'];

            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }

            $user->save();

            DB::commit();

            Alert::toast('Profile updated successfully!', 'success');
            return response()->json(
                [
                    'message' => 'Profile updated successfully!',
                    'user' => [
                        'name' => $user->name,
                        'email' => $user->email,
                        'image_url' => $user->image ? Storage::url($user->image) : null,
                    ],
                ],
                200,
            );
        } catch (ValidationException $e) {
            DB::rollBack();
            Alert::toast('Profile update failed!', 'error');
            return response()->json(['message' => $e->getMessage(), 'errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Profile update failed: ' . $e->getMessage());

            Alert::toast('Profile update failed!', 'error');

            return response()->json(['message' => 'An unexpected error occurred. Please try again.'], 500);
        }
    }

    private function handleProfileImage(string $imageBase64, ?string $oldImagePath): string
    {
        if ($oldImagePath && Storage::disk('public')->exists($oldImagePath)) {
            Storage::disk('public')->delete($oldImagePath);
        }

        preg_match('/data:image\/(?<extension>\w+);base64,/', $imageBase64, $matches);
        $extension = $matches['extension'] ?? 'jpg';

        $imageData = substr($imageBase64, strpos($imageBase64, ',') + 1);
        $imageData = base64_decode($imageData);

        $imageName = 'avatars/' . Str::random(20) . '.' . $extension;
        Storage::disk('public')->put($imageName, $imageData);

        return $imageName;
    }
}



