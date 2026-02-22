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
    <div id="mobileOverlay" class="mobile-overlay"></div>
    <main class="content">

        <!-- MOBILE TOP BAR -->
        <div class="mobile-topbar">
            <button id="mobileMenuBtn" class="mobile-menu-btn" type="button" aria-label="Toggle Menu">
                <svg viewBox="0 0 24 24" width="22" height="22" fill="none"
                    stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="6" x2="21" y2="6"></line>
                    <line x1="3" y1="12" x2="21" y2="12"></line>
                    <line x1="3" y1="18" x2="21" y2="18"></line>
                </svg>
            </button>
        </div>

        @yield('content')
    </main>
</div>

<script src="{{ asset('js/dashboard.js') }}" defer></script>
<script>
document.addEventListener('DOMContentLoaded', function () {

    /*
    =================================
    SIDEBAR COLLAPSE (DESKTOP)
    =================================
    */

    const sidebarBtn = document.getElementById('sidebarToggleBtn');
    const sidebar    = document.querySelector('.sidebar');

    // Load state saat refresh
    if (sidebar && localStorage.getItem('sidebarCollapsed') === 'true') {
        sidebar.classList.add('collapsed');
    }

    // Jika collapsed saat load → tutup semua dropdown
    if (sidebar && sidebar.classList.contains('collapsed')) {
        document.querySelectorAll('.menu-group')
            .forEach(group => group.classList.remove('open'));
    }

    if (sidebarBtn && sidebar) {
        sidebarBtn.addEventListener('click', function () {

            sidebar.classList.toggle('collapsed');

            localStorage.setItem(
                'sidebarCollapsed',
                sidebar.classList.contains('collapsed')
            );

            document.querySelectorAll('.menu-group')
                .forEach(group => group.classList.remove('open'));

        });
    }


    /*
    =================================
    DROPDOWN MENU
    =================================
    */

    const dropdownToggles = document.querySelectorAll('.dropdown-toggle');

    dropdownToggles.forEach(function (toggle) {

        toggle.addEventListener('click', function () {

            const parent = this.closest('.menu-group');

            document.querySelectorAll('.menu-group')
                .forEach(group => {
                    if (group !== parent) {
                        group.classList.remove('open');
                    }
                });

            parent.classList.toggle('open');

        });

    });

    document.querySelectorAll('.dropdown-item').forEach(item => {
        item.addEventListener('click', function () {
            const parent = this.closest('.menu-group');
            if (parent) {
                parent.classList.remove('open');
            }
        });
    });


    /*
    =================================
    MOBILE SIDEBAR
    =================================
    */

    const mobileBtn = document.getElementById('mobileMenuBtn');
    const mobileOverlay = document.getElementById('mobileOverlay');

    if (mobileBtn && sidebar) {

        mobileBtn.addEventListener('click', function () {

            sidebar.classList.toggle('mobile-active');
            mobileOverlay.classList.toggle('active');
            document.body.classList.toggle('mobile-open');

        });

        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function () {

                sidebar.classList.remove('mobile-active');
                mobileOverlay.classList.remove('active');
                document.body.classList.remove('mobile-open');

            });
        }

    }

});
</script>
@stack('scripts')

</body>
</html>
