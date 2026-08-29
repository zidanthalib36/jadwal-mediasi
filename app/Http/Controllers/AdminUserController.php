<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AdminUserController extends Controller
{
    /**
     * Menampilkan daftar user
     */
    public function index()
    {
        $users = User::orderBy('id', 'asc')->get();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user
     */
    public function create()
    {
        return view('admin.users.create');
    }

    /**
     * Menyimpan user baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:users,name',
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'whatsapp' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // =========================
        // BUAT USER
        // =========================

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'whatsapp' => $request->whatsapp,
            'password' => Hash::make($request->password),

            // Role otomatis menjadi user
            'role' => 'user',
        ]);

        // =========================
        // ACTIVITY LOG
        // =========================

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'create',
            'module' => 'Manajemen User',
            'subject_id' => $user->id,

            'description' =>
                'Admin menambahkan user "' .
                $user->name .
                '"',

            'changes' => [
                'name' => [
                    'old' => null,
                    'new' => $user->name,
                ],

                'username' => [
                    'old' => null,
                    'new' => $user->username,
                ],

                'email' => [
                    'old' => null,
                    'new' => $user->email,
                ],

                'whatsapp' => [
                    'old' => null,
                    'new' => $user->whatsapp,
                ],

                'role' => [
                    'old' => null,
                    'new' => $user->role,
                ],
            ],
        ]);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Menghapus user
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // =========================
        // ADMIN TIDAK BOLEH
        // MENGHAPUS AKUN SENDIRI
        // =========================

        if ($user->id === Auth::id()) {
            return redirect()
                ->route('admin.users.index')
                ->with(
                    'error',
                    'Anda tidak dapat menghapus akun sendiri.'
                );
        }

        // =========================
        // SIMPAN DATA USER
        // SEBELUM DIHAPUS
        // =========================

        $userId = $user->id;
        $userName = $user->name;
        $username = $user->username;
        $email = $user->email;
        $whatsapp = $user->whatsapp;
        $role = $user->role;

        // =========================
        // ACTIVITY LOG
        // HARUS DIBUAT SEBELUM USER DIHAPUS
        // =========================

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => 'delete',
            'module' => 'Manajemen User',
            'subject_id' => $userId,

            'description' =>
                'Admin menghapus user "' .
                $userName .
                '"',

            'changes' => [
                'name' => [
                    'old' => $userName,
                    'new' => null,
                ],

                'username' => [
                    'old' => $username,
                    'new' => null,
                ],

                'email' => [
                    'old' => $email,
                    'new' => null,
                ],

                'whatsapp' => [
                    'old' => $whatsapp,
                    'new' => null,
                ],

                'role' => [
                    'old' => $role,
                    'new' => null,
                ],
            ],
        ]);

        // =========================
        // HAPUS USER
        // =========================

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User berhasil dihapus.');
    }
}
