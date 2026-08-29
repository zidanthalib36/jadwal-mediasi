<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use App\Models\ActivityLog;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
{
    $user = $request->user();

    // Simpan data lama
    $emailLama = $user->email;
    $whatsappLama = $user->whatsapp;

    // Data baru
    $emailBaru = $request->validated('email');
    $whatsappBaru = $request->validated('whatsapp');

    // =========================
    // SIMPAN PERUBAHAN USER
    // =========================

    if ($emailLama !== $emailBaru) {
        $user->email = $emailBaru;
        $user->email_verified_at = null;
    }

    if ($whatsappLama !== $whatsappBaru) {
        $user->whatsapp = $whatsappBaru;
    }

    $user->save();

    // =========================
    // ACTIVITY LOG
    // =========================

    $changes = [];

    if ($emailLama !== $emailBaru) {
        $changes['email'] = [
            'old' => $emailLama,
            'new' => $emailBaru,
        ];
    }

    if ($whatsappLama !== $whatsappBaru) {
        $changes['whatsapp'] = [
            'old' => $whatsappLama,
            'new' => $whatsappBaru,
        ];
    }

    // Hanya buat log kalau ada perubahan
    if (!empty($changes)) {

        $descriptions = [];

        if ($emailLama !== $emailBaru) {
            $descriptions[] = 'Email';
        }

        if ($whatsappLama !== $whatsappBaru) {
            $descriptions[] = 'WhatsApp';
        }

        ActivityLog::create([
            'user_id' => $user->id,
            'action' => 'updated',
            'module' => 'Profile',
            'subject_id' => $user->id,
            'description' => 'Mengubah profil: ' . implode(', ', $descriptions),
            'changes' => $changes,
        ]);
    }

    return Redirect::route('profile.edit')
        ->with('status', 'profile-updated');
}
    /**
 * Update the user's password.
 */
public function updatePassword(Request $request): RedirectResponse
{
    $request->validate([
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    $user = $request->user();

    $user->update([
        'password' => Hash::make($request->password),
    ]);

    // Catat perubahan password
    // Password TIDAK disimpan ke dalam log.
    ActivityLog::create([
        'user_id' => $user->id,
        'action' => 'update',
        'module' => 'Password',
        'subject_id' => $user->id,
        'description' => 'Mengubah password akun "' . $user->name . '"',
        'changes' => null,
    ]);

    return Redirect::route('password.edit')
        ->with('status', 'password-updated');
}

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
