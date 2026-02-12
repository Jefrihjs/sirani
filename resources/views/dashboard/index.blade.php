@extends('layouts.dashboard')

@section('title', 'Dashboard')

@section('content')

<div class="dashboard-greeting">
    <div class="greeting-left">
        <h2>
            Halo, <span>{{ auth()->user()->name }}</span>
        </h2>
        <p>{{ now()->locale('id')->translatedFormat('l, d F Y') }}</p>

        <a href="{{ route('laporan_kegiatan.create') }}" class="btn-input-laporan">
            Input Laporan Kegiatan
        </a>
    </div>
</div>



<section class="dashboard-kpi">
    <div class="kpi-card kpi-blue">
        <div class="kpi-icon">
            <svg fill="#ffff" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" 
                    width="800px" height="800px" viewBox="0 0 20 20" enable-background="new 0 0 20 20" xml:space="preserve">
                <path d="M10,20C4.5,20,0,15.5,0,10S4.5,0,10,0s10,4.5,10,10S15.5,20,10,20z M10,2c-4.4,0-8,3.6-8,8s3.6,8,8,8s8-3.6,8-8S14.4,2,10,2
                    z"/>
                <path d="M13.8,12l-4-1C9.3,10.9,9,10.5,9,10V5c0-0.6,0.4-1,1-1s1,0.4,1,1v4.2l3.2,0.8c0.5,0.1,0.9,0.7,0.7,1.2
                    C14.8,11.8,14.3,12.1,13.8,12z"/>
            </svg>
        </div>
        <div class="kpi-body">
            <span class="kpi-label">Total Menit</span>
            <strong class="kpi-value">{{ $totalMenit }} menit</strong>
        </div>
    </div>

    
    <div class="kpi-card kpi-purple">
    <div class="kpi-icon">
            <svg
                viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg"
                aria-hidden="true"
                >
                <path
                    d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"
                    fill="currentColor"
                />
                <path
                    d="M14 2v6h6"
                    fill="currentColor"
                />
                </svg>


    </div>
        <div class="kpi-body">
            <span class="kpi-label">Laporan</span>
            <strong class="kpi-value">{{ $jumlahLaporan }}</strong>
        </div>
    </div>

    <div class="kpi-card kpi-green">
    <div class="kpi-icon">
        <svg viewBox="0 0 260 260" fill="#ffff" stroke="currentColor">
            <path d="M218,94h3.023C228.057,108.874,232,125.484,232,143
                c0,63.411-51.589,115-115,115S2,206.411,2,143S53.589,28,117,28
                c17.516,0,34.126,3.943,49,10.977V51.574l-7.979,7.979
                C145.64,53.441,131.715,50,117,50c-51.28,0-93,41.72-93,93
                s41.72,93,93,93s93-41.72,93-93c0-14.716-3.441-28.641-9.552-41.022
                L208.426,94H218z"/>
            <path d="M164,143c0,25.916-21.084,47-47,47s-47-21.084-47-47
                s21.084-47,47-47c1.472,0,2.926,0.077,4.363,0.21l18.351-18.351
                C132.596,75.37,124.957,74,117,74c-38.047,0-69,30.953-69,69
                s30.953,69,69,69s69-30.953,69-69c0-7.957-1.37-15.596-3.859-22.714
                l-18.35,18.35C163.923,140.074,164,141.528,164,143z"/>
            <path d="M218,74l40-40h-32V2l-40,40v17.857l-61.425,61.425
                c-2.373-0.828-4.92-1.283-7.575-1.283c-12.703,0-23,10.297-23,23
                c0,12.703,10.297,23,23,23c12.703,0,23-10.297,23-23
                c0-2.655-0.455-5.202-1.283-7.575L200.143,74H218z"/>
        </svg>

    </div>
    <div class="kpi-body">
        <span class="kpi-label">Status</span>
        <span class="status-badge">{{ $status }}</span>
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

    {{-- Produktivitas --}}
    <div class="card">
        <h3>Produktivitas</h3>

        <span class="status-badge
            @if ($status === 'Tercapai') success
            @elseif ($status === 'On Track') success
            @elseif ($status === 'Perlu Ditingkatkan') warning
            @else danger
            @endif
        ">
            {{ $status }}
        </span>

        <div class="kpi-progress">
            <div class="kpi-progress-bar">
                <div class="kpi-progress-fill" style="width: {{ $persenKPI }}%"></div>
            </div>

            <div class="kpi-progress-info">
                <strong>{{ $persenKPI }}%</strong>
                <span>{{ $totalMenit }} / {{ $targetMenit }} menit</span>
            </div>
        </div>
    </div>

    {{-- Grafik Produktivitas Bulanan --}}
    <div class="card">
        <h3>Produktivitas Bulanan</h3>
        <canvas id="chartProduktivitas" height="100"></canvas>
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
                label: 'Menit',
                data: @json($dataGrafik),

            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: value => value + ' m'
                    }
                }
            }
        }
    });
}
</script>
@endpush
