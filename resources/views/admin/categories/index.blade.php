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
                    <h4>Manajemen Kategori</h4>
                    <p class="text-muted mb-0">Kelola kategori aspirasi.</p>
                </div>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">Tambah Kategori</a>
            </div>

            <!-- Kategori Table -->
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Daftar Kategori</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nama Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($categories as $category)
                                <tr>
                                    <td>{{ $category->id_kategori }}</td>
                                    <td>{{ $category->ket_kategori }}</td>
                                    <td>
                                        <a href="{{ route('admin.categories.edit', $category->id_kategori) }}" class="btn btn-sm btn-outline-primary">Edit</a>
                                        <form method="POST" action="{{ route('admin.categories.destroy', $category->id_kategori) }}" class="d-inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center">Belum ada kategori.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection