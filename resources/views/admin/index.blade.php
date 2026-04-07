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
                        <a href="{{ route('admin.aspirasi.index') }}" class="list-group-item list-group-item-action border-0 px-4 py-3 active">
                            <i class="bi bi-list-check me-3"></i>
                            <span class="fw-medium">Manajemen Aspirasi</span>
                        </a>
                        <a href="{{ route('admin.users.index') }}" class="list-group-item list-group-item-action border-0 px-4 py-3">
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
                    <h4>Data Aspirasi</h4>
                    <p class="text-muted mb-0">Kelola aspirasi dan pengguna aplikasi.</p>
                </div>
                <div>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-primary me-2">Manajemen Pengguna</a>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-success">Tambah Akun</a>
                </div>
            </div>

    <!-- Filter Form -->
    <div class="card mb-4">
        <div class="card-header">
            <h5 class="mb-0">Filter Aspirasi</h5>
        </div>
        <div class="card-body">
            <form method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="tanggal" class="form-label">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="form-control" value="{{ $request->tanggal ?? '' }}">
                </div>
                <div class="col-md-3">
                    <label for="siswa" class="form-label">Siswa</label>
                    <select name="siswa" id="siswa" class="form-select">
                        <option value="">Semua Siswa</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ $request->siswa == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="kategori" class="form-label">Kategori</label>
                    <select name="kategori" id="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id_kategori }}" {{ $request->kategori == $category->id_kategori ? 'selected' : '' }}>{{ $category->ket_kategori }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">Filter</button>
                    <a href="{{ route('admin.aspirasi.index') }}" class="btn btn-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Aspirasi Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Aspirasi</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>NIS</th>
                            <th>Siswa</th>
                            <th>Lokasi</th>
                            <th>Kategori</th>
                            <th>Keterangan</th>                            <th>Gambar</th>                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td>{{ $d->inputAspirasi->nis ?? '-' }}</td>
                            <td>{{ $d->inputAspirasi->siswa->name ?? '-' }}</td>
                            <td>{{ $d->inputAspirasi->lokasi ?? '-' }}</td>
                            <td>{{ $d->category->ket_kategori ?? '-' }}</td>
                            <td>{{ Str::limit($d->inputAspirasi->keterangan ?? '-', 50) }}</td>
                            <td>
                                @if($d->inputAspirasi->gambar)
                                    <img src="{{ asset('storage/' . $d->inputAspirasi->gambar) }}" alt="Gambar" class="img-thumbnail" style="max-width: 50px; max-height: 50px;">
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge 
                                    @if($d->status == 'Menunggu') bg-warning
                                    @elseif($d->status == 'Proses') bg-info
                                    @elseif($d->status == 'Selesai') bg-success
                                    @endif">
                                    {{ $d->status }}
                                </span>
                            </td>
                            <td>{{ $d->created_at->format('d M Y') }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.aspirasi.update', $d->id_aspirasi) }}" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-2">
                                        <select name="status" class="form-select form-select-sm">
                                            <option value="Menunggu" {{ $d->status == 'Menunggu' ? 'selected' : '' }}>Menunggu</option>
                                            <option value="Proses" {{ $d->status == 'Proses' ? 'selected' : '' }}>Proses</option>
                                            <option value="Selesai" {{ $d->status == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="message" class="form-control form-control-sm" placeholder="Feedback" rows="2">{{ $d->feedbacks->last()->message ?? '' }}</textarea>
                                    </div>
                                    <button type="submit" class="btn btn-success btn-sm">Update</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center">Tidak ada aspirasi ditemukan.</td>
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