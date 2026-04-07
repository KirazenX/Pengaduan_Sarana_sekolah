@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4>Riwayat Aspirasi</h4>
            <p class="text-muted mb-0">Lihat status dan feedback aspirasi Anda.</p>
        </div>
        <a href="{{ route('siswa.aspirasi.create') }}" class="btn btn-primary">Buat Aspirasi Baru</a>
    </div>

    <!-- Riwayat Aspirasi Table -->
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0">Daftar Aspirasi Anda</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>NIS</th>
                            <th>Lokasi</th>
                            <th>Keterangan</th>
                            <th>Kategori</th>
                            <th>Status</th>
                            <th>Tanggal Dibuat</th>
                            <th>Feedback</th>
                            <th>Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $d)
                        <tr>
                            <td>{{ $d->inputAspirasi->nis ?? '-' }}</td>
                            <td>{{ $d->inputAspirasi->lokasi ?? '-' }}</td>
                            <td>{{ Str::limit($d->inputAspirasi->keterangan ?? '-', 50) }}
                                @if($d->inputAspirasi->gambar)
                                    <i class="bi bi-image text-muted ms-1" title="Ada gambar"></i>
                                @endif
                            </td>
                            <td>{{ $d->category->ket_kategori ?? '-' }}</td>
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
                                @if($d->feedbacks->isNotEmpty())
                                    @foreach($d->feedbacks as $f)
                                        <div class="border p-2 mb-1 bg-light">{{ $f->message }}</div>
                                    @endforeach
                                @else
                                    <em class="text-muted">Belum ada feedback</em>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('siswa.aspirasi.show', $d->id_aspirasi) }}" class="btn btn-sm btn-outline-primary">Lihat</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center">Belum ada aspirasi yang dibuat.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection