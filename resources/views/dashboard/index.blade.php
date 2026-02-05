@extends('layouts.dashboard')

@section('content')
<div class="container-fluid p-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold text-dark m-0">Ringkasan Bulan Ini</h3>
        <div class="badge rounded-pill px-3 py-2 shadow-sm" style="background-color: {{ $statusColor }}; font-size: 0.9rem;">
            <i class="fas fa-info-circle me-1"></i> Status: {{ $statusText }}
        </div>
    </div>

    {{-- SUMMARY CARDS --}}
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center p-3 transition-hover">
                <small class="text-muted text-uppercase fw-semibold">Total Menit</small>
                <h2 class="fw-bold mt-2 mb-0">{{ number_format($totalMenit) }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center p-3 transition-hover">
                <small class="text-muted text-uppercase fw-semibold">Target</small>
                <h2 class="fw-bold mt-2 mb-0 text-primary">{{ number_format($target) }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center p-3 transition-hover">
                <small class="text-muted text-uppercase fw-semibold">Sisa</small>
                <h2 class="fw-bold mt-2 mb-0 {{ $sisa > 0 ? 'text-danger' : 'text-success' }}">{{ number_format($sisa) }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm h-100 text-center p-3 transition-hover">
                <small class="text-muted text-uppercase fw-semibold">Capaian</small>
                <h2 class="fw-bold mt-2 mb-0">{{ $persen }}%</h2>
                <div class="progress mt-2" style="height: 6px;">
                    <div class="progress-bar" role="progressbar" style="width: {{ $persen }}%; background-color: {{ $statusColor }}"></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- PROGRESS CHART --}}
        <div class="col-lg-4 mb-4">
            <div class="card border-0 shadow-sm p-4 h-100">
                <h5 class="fw-bold mb-4">Progress Laporan</h5>
                <div class="d-flex justify-content-center align-items-center" style="position: relative;">
                    <canvas id="progressChart" style="max-height: 250px;"></canvas>
                    <div style="position: absolute; top: 55%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
                        <span class="d-block fw-bold h4 m-0">{{ $persen }}%</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- TABLE KEGIATAN --}}
        <div class="col-lg-8 mb-4">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="fw-bold m-0">Kegiatan Terakhir</h5>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-muted">
                            <tr>
                                <th class="ps-4">TANGGAL</th>
                                <th>KEGIATAN</th>
                                <th>WAKTU</th>
                                <th class="text-center pe-4">DURASI</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($kegiatanTerakhir as $item)
                                <tr>
                                    <td class="ps-4">
                                        <span class="text-dark fw-medium">{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</span>
                                    </td>
                                    <td>
                                        <div class="fw-bold text-dark">{{ $item->kegiatan->nama_kegiatan ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <small class="text-muted bg-light px-2 py-1 rounded">
                                            {{ \Carbon\Carbon::parse($item->jam_mulai)->format('H:i') }} - {{ \Carbon\Carbon::parse($item->jam_selesai)->format('H:i') }}
                                        </small>
                                    </td>
                                    <td class="text-center pe-4">
                                        <span class="badge bg-soft-success text-success px-3">{{ $item->durasi_menit }} min</span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-5 text-muted italic">
                                        <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="50" class="opacity-25 mb-2 d-block mx-auto">
                                        Belum ada kegiatan tercatat.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Styles untuk mempercantik */
    .card { border-radius: 12px; transition: transform 0.2s ease; }
    .transition-hover:hover { transform: translateY(-5px); }
    .bg-soft-success { background-color: #e8f5e9; color: #2e7d32; }
    .table thead th { font-size: 0.75rem; letter-spacing: 0.05em; }
    .progress { border-radius: 10px; background-color: #f0f0f0; }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('progressChart');
    if (!canvas) return;

    new Chart(canvas.getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Tercapai', 'Sisa'],
            datasets: [{
                data: [{{ $totalMenit }}, {{ max(0, $sisa) }}],
                backgroundColor: ['#22c55e', '#f3f4f6'],
                hoverBackgroundColor: ['#16a34a', '#e5e7eb'],
                borderWidth: 0,
                spacing: 2
            }]
        },
        options: {
            cutout: '75%',
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }
            }
        }
    });
});
</script>
@endpush