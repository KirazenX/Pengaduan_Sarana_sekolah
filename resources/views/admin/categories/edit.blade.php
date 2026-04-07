@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row">
        <!-- Sidebar -->
        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-0">
                    <div class="p-3 border-bottom">
                        <h6 class="mb-0 fw-bold text-primary">
                            <i class="bi bi-grid-3x3-gap me-2"></i>Dashboard Admin
                        </h6>
                    </div>
                    <div class="list-group list-group-flush">
                        <a href="{{ route('admin.aspirasi.index') }}" class="list-group-item list-group-item-action border-0 px-4 py-3">
                            <i class="bi bi-list-check me-3"></i>
                            <span class="fw-medium">Manajemen Aspirasi</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action border-0 px-4 py-3">
                            <i class="bi bi-people me-3"></i>
                            <span class="fw-medium">Manajemen Pengguna</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 active">
                            <i class="bi bi-tags me-3"></i>
                            <span class="fw-medium">Manajemen Kategori</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="col-md-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4>Edit Kategori</h4>
                    <p class="text-muted mb-0">Perbarui informasi kategori.</p>
                </div>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

            <div class="card">
                <div class="card-body">
                    <form method="POST" action="{{ route('admin.categories.update', $category->id_kategori) }}">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="ket_kategori" class="form-label">Nama Kategori</label>
                            <input type="text" name="ket_kategori" id="ket_kategori" class="form-control" value="{{ old('ket_kategori', $category->ket_kategori) }}" required>
                            @error('ket_kategori')
                                <div class="text-danger">{{ $message }}</div>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary">Update Kategori</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection