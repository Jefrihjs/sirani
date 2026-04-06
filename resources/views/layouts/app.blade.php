<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        {{-- CSP Meta Tag --}}
        <meta http-equiv="Content-Security-Policy" content="default-src 'self' http: https: data: blob: 'unsafe-inline' 'unsafe-eval';">
        
        <title>{{ config('app.name', 'SiCERIA - Sistem Pelaporan ASN') }}</title>

        {{-- CSS Lokal (Pastikan file sudah ada di public/css) --}}
        <link rel="stylesheet" href="{{ asset('css/cropper.css') }}">
        <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ time() }}">
        
        {{-- JS Lokal (PENTING: Ganti CDN ke Asset Lokal) --}}
        <script src="{{ asset('js/tailwind.min.js') }}"></script>
        <script defer src="{{ asset('js/alpine.min.js') }}"></script>

        <style>
            header, main {
                transition: all 0.5s ease-in-out;
                margin-left: 18rem; 
            }
            .sidebar-is-collapsed header, 
            .sidebar-is-collapsed main {
                margin-left: 5rem; 
            }
            @media (max-width: 1024px) {
                header, main { margin-left: 0 !important; }
            }
            ::-webkit-scrollbar { width: 5px; }
            ::-webkit-scrollbar-track { background: #f1f1f1; }
            ::-webkit-scrollbar-thumb { background: #3b82f6; border-radius: 10px; }
        </style>

        {{-- JS Pendukung Lokal --}}
        <script src="{{ asset('js/sweetalert2.js') }}"></script>
        <script src="{{ asset('js/cropper.js') }}"></script>
        <script src="{{ asset('js/app.js') }}?v={{ time() }}" defer></script>
    </head>
    
    <body class="font-sans antialiased bg-gray-50"
          {{-- Inisialisasi status sidebar di level Body --}}
          x-data="{ isCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
          :class="isCollapsed ? 'sidebar-is-collapsed' : ''"
          {{-- dengerin signal dari file sidebar.blade.php --}}
          @sidebar-toggled.window="isCollapsed = $event.detail">

        <div class="min-h-screen">
            {{-- Bagian Sidebar/Navigasi --}}
            @include('layouts.navigation')

            {{-- Bagian Header Halaman --}}
            @isset($header)
            <header class="bg-white shadow-sm border-b border-gray-100 sticky top-0 z-40">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
            @endisset

            {{-- Bagian Konten Utama (Slot) --}}
            <main class="py-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                     {{ $slot }}
                </div>
            </main>
        </div>

        
        {{ $scripts ?? '' }}

        
        <script>
            function konfirmasiHapus(button, event) {
                if (event) event.preventDefault();
                
                const form = button.closest('.form-hapus') || button.closest('form');

                Swal.fire({
                    title: 'HAPUS DATA?',
                    text: "Data akan dihapus permanen dari sistem",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#e11d48',
                    confirmButtonText: 'YA, HAPUS',
                    cancelButtonText: 'BATAL',
                    customClass: {
                        popup: 'rounded-[2rem]',
                        confirmButton: 'rounded-xl px-6 py-3',
                        cancelButton: 'rounded-xl px-6 py-3'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            }
        </script>
    </body>
</html>