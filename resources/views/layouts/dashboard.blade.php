<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIRANI')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
</head>

<body>

<div class="layout">

    @include('partials.sidebar')

    <main class="content">
        @yield('content')
    </main>
</div>

<script src="{{ asset('js/dashboard.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    =========================
    SIDEBAR COLLAPSE (WITH PERSIST)
    =========================
    */

    const sidebarBtn = document.getElementById('sidebarToggleBtn');
    const sidebar    = document.querySelector('.sidebar');

    // === LOAD STATE SAAT REFRESH ===
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }

    // 🔥 Jika sidebar dalam kondisi collapsed saat load,
    // paksa semua dropdown tertutup
    if (sidebar.classList.contains('collapsed')) {
        document.querySelectorAll('.menu-group')
            .forEach(group => group.classList.remove('open'));
    }

    if (sidebarBtn && sidebar) {
        sidebarBtn.addEventListener('click', function () {

            sidebar.classList.toggle('collapsed');

            // Simpan state ke localStorage
            localStorage.setItem(
                'sidebarCollapsed',
                sidebar.classList.contains('collapsed')
            );

            // Tutup semua dropdown saat collapse
            document.querySelectorAll('.menu-group')
                .forEach(group => group.classList.remove('open'));
            
        });
    }

    /*
    =========================
    DROPDOWN (Auto Close Others)
    =========================
    */

    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(function (toggle) {

        toggle.addEventListener('click', function () {

            const parent = this.closest('.menu-group');

            // Tutup semua kecuali yang diklik
            document.querySelectorAll('.menu-group')
                .forEach(group => {
                    if (group !== parent) {
                        group.classList.remove('open');
                    }
                });

            // Toggle yang sekarang
            parent.classList.toggle('open');

        });

    });

    // 👇 TAMBAHKAN DI SINI
    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function () {
            const parent = this.closest('.menu-group');
            if (parent) {
                parent.classList.remove('open');
            }
        });
    });

});

</script>



@stack('scripts')

</body>
</html>
