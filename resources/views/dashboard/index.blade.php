@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-hero">
    <div class="hero-left">
        <h1>Halo, <span>{{ auth()->user()->name }}</span></h1>
        <p>{{ now()->translatedFormat('l, d F Y') }}</p>
    </div>

    <div class="hero-right">
        <a href="{{ route('laporan_kegiatan.create') }}" class="btn-primary">
            + Input Laporan
        </a>
    </div>
</div>

<div class="sirani-grid">

    {{-- TOTAL MENIT --}}
    <div class="sirani-card">
        <span class="sirani-label">TOTAL MENIT</span>
        <h2 class="sirani-value">
            {{ $totalMenit }} <small>menit</small>
        </h2>

        <div class="sirani-progress">
            <div class="sirani-bar"
                 style="width: {{ $persenKPI}}%">
            </div>
        </div>

        <span class="sirani-meta">
            {{ $persenKPI }}% dari target 6000 menit
        </span>
    </div>

    {{-- LAPORAN --}}
    <div class="sirani-card">
        <span class="sirani-label">LAPORAN</span>
        <h2 class="sirani-value">
            {{ $jumlahLaporan }}
        </h2>

        <span class="sirani-meta">
            Total laporan bulan ini
        </span>
    </div>

    {{-- STATUS --}}
    <div class="sirani-card">
        <span class="sirani-label">STATUS</span>
        <h2 class="status-title {{ $badgeClass }}">
            {{ $status }}
        </h2>

        <span class="status-badge {{ $badgeClass }}">
            {{ $persenKPI}}% Tercapai
        </span>
    </div>

</div>


</section>

<section class="dashboard-main">

    {{-- Kegiatan Terakhir --}}
    <div class="card">
        <h3>Kegiatan Terakhir</h3>

        @forelse ($kegiatanTerakhir as $item)
            <p><strong>{{ $item->nama_kegiatan }}</strong></p>
            <small>
                {{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}
                • {{ substr($item->jam_mulai, 0, 5) }} - {{ substr($item->jam_selesai, 0, 5) }}
                • {{ $item->durasi_menit }} m
            </small>
            <hr>
        @empty
            <p>Tidak ada kegiatan.</p>
        @endforelse
    </div>

    {{-- Grafik Produktivitas Bulanan --}}
    <div class="chart-wrapper">
    <canvas id="chartProduktivitas"></canvas>
</div>

</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('chartProduktivitas');

if (ctx) {
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'],
            datasets: [{
                data: @json($dataGrafik),
                backgroundColor: '#2563eb',
                borderRadius: 6,
                barThickness: 26,
                hoverBackgroundColor: '#1d4ed8'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#111827',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    padding: 10,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.raw + ' menit';
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { display: false },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 12,
                            family: 'Source Sans 3'
                        }
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e5e7eb'
                    },
                    ticks: {
                        color: '#64748b',
                        font: {
                            size: 12,
                            family: 'Source Sans 3'
                        },
                        callback: value => value + ' m'
                    }
                }
            }
        }
    });
}
</script>
@endpush
