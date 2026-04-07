<?php

namespace App\Http\Controllers;

use App\Models\Aspirasi;
use App\Models\Category;
use App\Models\InputAspirasi;
use Illuminate\Http\Request;

class AspirasiController extends Controller
{
    public function index()
    {
        $userNis = auth()->user()->nis;
        $data = Aspirasi::with(['inputAspirasi.siswa', 'category', 'feedbacks'])
            ->whereHas('inputAspirasi', function ($query) use ($userNis) {
                $query->where('nis', $userNis);
            })
            ->get();

        $categories = Category::all();
        return view('siswa.index', compact('data', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('siswa.create', compact('categories'));
    }

    public function show($id)
    {
        $userNis = auth()->user()->nis;
        $aspirasi = Aspirasi::with(['inputAspirasi.siswa', 'category', 'feedbacks'])
            ->whereHas('inputAspirasi', function ($query) use ($userNis) {
                $query->where('nis', $userNis);
            })
            ->findOrFail($id);

        return view('siswa.show', compact('aspirasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_kategori' => 'required|exists:kategoris,id_kategori',
            'lokasi' => 'required|string|max:50',
            'keterangan' => 'required|string|max:50',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('aspirasi', 'public');
        }

        $inputAspirasi = InputAspirasi::create([
            'nis' => auth()->user()->nis,
            'id_kategori' => $request->id_kategori,
            'lokasi' => $request->lokasi,
            'keterangan' => $request->keterangan,
            'gambar' => $gambarPath,
        ]);

        Aspirasi::create([
            'id_pelaporan' => $inputAspirasi->id_pelaporan,
            'id_kategori' => $request->id_kategori,
            'status' => 'Menunggu',
        ]);

        return redirect()->route('siswa.aspirasi.index')
            ->with('success', 'Aspirasi berhasil dikirim');
    }
}
