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
                        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 active">
                            <i class="bi bi-people me-3"></i>
                            <span class="fw-medium">Manajemen Pengguna</span>
                        </a>
                        <a href="{{ route('admin.categories.index') }}" class="list-group-item list-group-item-action border-0 px-4 py-3">
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
                    <h4>Manajemen Pengguna</h4>
                    <p class="text-muted mb-0">Lihat, tambah, dan edit akun siswa atau admin.</p>
                </div>
                <div>
                    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary me-2">Kembali ke Aspirasi</a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah Akun</a>
                </div>
            </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Pengguna</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>NIS</th>
                            <th>Kelas</th>
                            <th>Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    <span class="badge 
                                        @if($user->role == 'admin') bg-primary
                                        @else bg-secondary
                                        @endif">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td>{{ $user->role == 'siswa' ? $user->nis : '-' }}</td>
                                <td>{{ $user->role == 'siswa' ? $user->kelas : '-' }}</td>
                                <td>{{ $user->created_at->format('d M Y') }}</td>
                                <td>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Tidak ada pengguna.</td>
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