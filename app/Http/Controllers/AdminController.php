<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Feedback;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    // Menampilkan daftar aspirasi dengan filter berdasarkan tanggal, bulan, siswa, dan kategori
    public function index(Request $request)
    {
        $query = Aspirasi::with(['inputAspirasi.siswa', 'category', 'feedbacks']);

        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->bulan) {
            $query->whereMonth('created_at', $request->bulan);
        }

        if ($request->siswa) {
            $student = User::where('role', 'siswa')->find($request->siswa);
            if ($student) {
                $query->whereHas('inputAspirasi', function ($q) use ($student) {
                    $q->where('nis', $student->nis);
                });
            }
        }

        if ($request->kategori) {
            $query->where('id_kategori', $request->kategori);
        }

        $data = $query->get();
        $users = User::where('role', 'siswa')->get();
        $categories = \App\Models\Category::all();

        return view('admin.index', compact('data', 'users', 'categories', 'request'));
    }

    // Menampilkan daftar pengguna dengan opsi untuk mengelola akun siswa dan admin
    public function usersIndex()
    {
        $users = User::orderBy('role')->orderBy('name')->get();

        return view('admin.users.index', compact('users'));
    }

    // Menampilkan form untuk membuat akun pengguna baru
    public function createUser()
    {
        return view('admin.users.create');
    }

    // Menyimpan akun pengguna baru ke database
    public function storeUser(Request $request)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'role' => ['required', 'string', 'in:siswa,admin'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ];

        if ($request->role === 'siswa') {
            $rules['nis'] = ['required', 'string', 'max:20'];
            $rules['kelas'] = ['required', 'string', 'max:50'];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ];

        if ($request->role === 'siswa') {
            $data['nis'] = $request->nis;
            $data['kelas'] = $request->kelas;
        }

        User::create($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil ditambahkan');
    }

    // Menampilkan form untuk mengedit akun pengguna yang sudah ada
    public function editUser($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    // Memperbarui akun pengguna yang sudah ada di database
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'string', 'in:siswa,admin'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ];

        if ($request->role === 'siswa') {
            $rules['nis'] = ['required', 'string', 'max:20'];
            $rules['kelas'] = ['required', 'string', 'max:50'];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => $request->password ? Hash::make($request->password) : $user->password,
        ];

        if ($request->role === 'siswa') {
            $data['nis'] = $request->nis;
            $data['kelas'] = $request->kelas;
        } else {
            // Jika role diubah ke admin, kosongkan nis dan kelas
            $data['nis'] = null;
            $data['kelas'] = null;
        }

        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Akun pengguna berhasil diperbarui');
    }

    // Memperbarui status aspirasi dan menambahkan feedback dari admin
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Menunggu,Proses,Selesai',
            'message' => 'required|string',
        ]);

        $aspirasi = Aspirasi::findOrFail($id);

        $aspirasi->update([
            'status' => $request->status,
        ]);

        Feedback::create([
            'id_aspirasi' => $id,
            'admin_id' => auth()->id(),
            'message' => $request->message,
        ]);

        return back()->with('success', 'Status aspirasi berhasil diperbarui');
    }
}
