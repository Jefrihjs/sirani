<!DOCTYPE html>
<html lang="id">
<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">

<title>@yield('title','Dashboard')</title>

{{-- CSS dari Laravel Mix --}}
<link rel="stylesheet" href="{{ asset('css/app.css') }}">

</head>

<body class="bg-slate-50 antialiased"
      x-data="{ isCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
      @sidebar-toggled.window="isCollapsed = $event.detail">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- CONTENT --}}
    <main class="flex-1 transition-all duration-500 min-w-0 overflow-hidden"
          :class="isCollapsed ? 'md:ml-20' : 'md:ml-72'">

        <div class="p-0">
            @yield('content')
        </div>

    </main>

</div>

{{-- JS dari Laravel Mix --}}
<script src="{{ asset('js/app.js') }}"></script>

{{-- SweetAlert --}}
<script src="{{ asset('js/sweetalert2.js') }}"></script>

@stack('scripts')

<script>
window.konfirmasiHapus = function(button, event) {

    if (event) event.preventDefault();

    const form = button.closest('.form-hapus') || button.closest('form');

    if (typeof Swal === 'undefined') {
        if (confirm('Hapus data ini?')) form.submit();
        return;
    }

    Swal.fire({
        title: 'HAPUS DATA?',
        text: "Data akan dihapus permanen",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e11d48',
        confirmButtonText: 'YA, HAPUS!',
        cancelButtonText: 'BATAL'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });

}
</script>

</body>
</html>