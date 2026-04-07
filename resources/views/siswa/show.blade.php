@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Detail Aspirasi</h4>
            <p class="text-muted mb-0">Informasi lengkap dan feedback untuk aspirasi Anda.</p>
        </div>
        <a href="{{ route('siswa.aspirasi.index') }}" class="btn btn-secondary">Kembali ke Riwayat</a>
    </div>

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <h5 class="mb-0">Aspirasi #{{ $aspirasi->id_aspirasi }}</h5>
                <small class="text-muted">Kategori: {{ $aspirasi->category->ket_kategori ?? '-' }}</small>
            </div>
            <span class="badge bg-{{ $aspirasi->status == 'Menunggu' ? 'warning' : ($aspirasi->status == 'Proses' ? 'info' : 'success') }}">
                {{ $aspirasi->status }}
            </span>
        </div>
        <div class="card-body">
            <div class="row gy-3">
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <h6 class="mb-2">Lokasi</h6>
                        <p class="mb-0 text-muted">{{ $aspirasi->inputAspirasi->lokasi ?? '-' }}</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="border rounded p-3 h-100">
                        <h6 class="mb-2">Tanggal Dibuat</h6>
                        <p class="mb-0 text-muted">{{ $aspirasi->created_at->format('d M Y H:i') }}</p>
                    </div>
                </div>
                <div class="col-12">
                    <div class="border rounded p-3">
                        <h6 class="mb-2">Keterangan</h6>
                        <p class="mb-0 text-muted">{{ $aspirasi->inputAspirasi->keterangan ?? '-' }}</p>
                        @if($aspirasi->inputAspirasi->gambar)
                            <div class="mt-3">
                                <h6 class="mb-2">Gambar</h6>
                                <img src="{{ asset('storage/' . $aspirasi->inputAspirasi->gambar) }}" alt="Gambar Aspirasi" class="img-fluid rounded" style="max-width: 100%; height: auto;">
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header">Feedback</div>
        <div class="card-body">
            @if($aspirasi->feedbacks->isEmpty())
                <div class="text-muted">Belum ada feedback untuk aspirasi ini.</div>
            @else
                @foreach($aspirasi->feedbacks as $feedback)
                    <div class="border rounded p-3 mb-3">
                        <p class="mb-1">{{ $feedback->message }}</p>
                        <div class="text-muted small">Dikirim oleh admin pada {{ $feedback->created_at->format('d M Y H:i') }}</div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
@endsection