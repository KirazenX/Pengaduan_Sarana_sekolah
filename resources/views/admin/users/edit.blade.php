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
                    <h4>Edit Akun Pengguna</h4>
                    <p class="text-muted mb-0">Perbarui informasi akun pengguna.</p>
                </div>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Kembali</a>
            </div>

            <div class="card">
                <div class="card-body">
                <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select name="role" id="role" class="form-control" required>
                            <option value="siswa" {{ old('role', $user->role) == 'siswa' ? 'selected' : '' }}>Siswa</option>
                            <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                        @error('role')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="nis-field" style="display: {{ old('role', $user->role) == 'siswa' ? 'block' : 'none' }};">
                        <label for="nis" class="form-label">NIS</label>
                        <input type="text" name="nis" id="nis" class="form-control" value="{{ old('nis', $user->nis) }}">
                        @error('nis')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3" id="kelas-field" style="display: {{ old('role', $user->role) == 'siswa' ? 'block' : 'none' }};">
                        <label for="kelas" class="form-label">Kelas</label>
                        <input type="text" name="kelas" id="kelas" class="form-control" value="{{ old('kelas', $user->kelas) }}">
                        @error('kelas')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru (opsional)</label>
                        <input type="password" name="password" id="password" class="form-control">
                        @error('password')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password</label>
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control">
                    </div>

                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary me-2">Batal</a>
                </form>
            </div>
        </div>
    </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('role').addEventListener('change', function() {
        const role = this.value;
        const nisField = document.getElementById('nis-field');
        const kelasField = document.getElementById('kelas-field');
        if (role === 'siswa') {
            nisField.style.display = 'block';
            kelasField.style.display = 'block';
        } else {
            nisField.style.display = 'none';
            kelasField.style.display = 'none';
        }
    });
</script>
@endsection