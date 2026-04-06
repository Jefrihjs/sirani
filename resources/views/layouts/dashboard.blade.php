<body class="bg-slate-50 antialiased" 
      x-data="{ isCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
      @sidebar-toggled.window="isCollapsed = $event.detail">

    <div class="flex min-h-screen">
        @include('partials.sidebar')

        <main class="flex-1 transition-all duration-500 min-w-0 overflow-hidden"
              :class="isCollapsed ? 'md:ml-20' : 'md:ml-72'">
            <div class="p-0">
                @yield('content')
            </div>
        </main>
    </div>

    
    <script src="{{ asset('js/sweetalert2.js') }}"></script>

    
    @stack('scripts')

    
    <script>
        window.konfirmasiHapus = function(button, event) {
            if (event) event.preventDefault();
            
            const form = button.closest('.form-hapus') || button.closest('form');
            
            if (typeof Swal === 'undefined') {
                if (confirm('Hapus data ini, Pak?')) form.submit();
                return;
            }

            Swal.fire({
                title: 'HAPUS DATA?',
                text: "Data akan dihapus permanen dari SiCERIA",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e11d48',
                confirmButtonText: 'YA, HAPUS!',
                cancelButtonText: 'BATAL',
                customClass: {
                    popup: 'rounded-[2rem]',
                    confirmButton: 'rounded-xl px-6 py-3 font-bold',
                    cancelButton: 'rounded-xl px-6 py-3 font-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
    </script>
</body>