<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\M_Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index(Request $request)
    {
        $admins = M_Admin::when($request->search, function ($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.admins.index', [
            'admins' => $admins,
            'search' => $request->search,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama'     => 'required|string|max:100',
            'email'    => 'required|email|unique:admins,email',
            'password' => 'required|string|min:6',
            'role'     => 'required|in:superadmin,admin,operator',
            'status'   => 'required|in:active,inactive',
        ]);

        M_Admin::create([
            'nama'     => $request->nama,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'status'   => $request->status,
        ]);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil ditambahkan.');
    }

    public function update(Request $request, int $id)
    {
        $admin = M_Admin::findOrFail($id);

        $request->validate([
            'nama'   => 'required|string|max:100',
            'email'  => 'required|email|unique:admins,email,' . $id,
            'role'   => 'required|in:superadmin,admin,operator',
            'status' => 'required|in:active,inactive',
        ]);

        $data = [
            'nama'   => $request->nama,
            'email'  => $request->email,
            'role'   => $request->role,
            'status' => $request->status,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $admin->update($data);

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        // Cegah hapus diri sendiri
        if ($id == auth('admin')->id()) {
            return redirect()->route('admin.admins.index')
                ->with('error', 'Tidak bisa menghapus akun sendiri.');
        }

        M_Admin::findOrFail($id)->delete();

        return redirect()->route('admin.admins.index')
            ->with('success', 'Admin berhasil dihapus.');
    }
}