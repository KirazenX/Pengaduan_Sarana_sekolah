@extends('layouts.app')

@section('content')
<div class="container">
    <h4>Buat Aspirasi Baru</h4>

    <form method="POST" action="/aspirasi" enctype="multipart/form-data">
        @csrf

            <div class="mb-3">
            <label for="id_kategori" class="form-label">Kategori</label>
            <select name="id_kategori" id="id_kategori" class="form-control" required>
                <option value="">Pilih Kategori</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id_kategori }}">{{ $category->ket_kategori }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="lokasi" class="form-label">Lokasi</label>
            <input type="text" name="lokasi" id="lokasi" class="form-control" placeholder="Lokasi aspirasi" required>
        </div>

        <div class="mb-3">
            <label for="keterangan" class="form-label">Keterangan</label>
            <textarea name="keterangan" id="keterangan" class="form-control" rows="4" placeholder="Jelaskan aspirasi Anda" required></textarea>
        </div>

        <div class="mb-3">
            <label for="gambar" class="form-label">Gambar (Opsional)</label>
            <input type="file" name="gambar" id="gambar" class="form-control" accept="image/*">
            <div class="form-text">Format: JPEG, PNG, JPG, GIF. Maksimal 2MB.</div>
        </div>

        <button type="submit" class="btn btn-primary">Kirim Aspirasi</button>
        <a href="/aspirasi" class="btn btn-secondary">Kembali</a>
    </form>
</div>
@endsection