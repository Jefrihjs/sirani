<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SiCERIA</title>
<script src="https://cdn.tailwindcss.com"></script>
    {{-- Panggil hanya yang lokal di sini --}}
    <script src="{{ asset('js/tailwind.js') }}"></script>
    <script src="{{ asset('js/alpine.js') }}" defer></script>
    
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    
    <style>
       [x-cloak] { display: none !important; }
    
       svg { width: 24px !important; height: 24px !important; }
        .w-12, .h-12 { width: 48px !important; height: 48px !important; }
        .w-72 { width: 288px !important; }
        [x-cloak] { display: none !important; }
    
    </style>
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