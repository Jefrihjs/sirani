<body class="bg-slate-50 antialiased" 
      x-data="{ isCollapsed: localStorage.getItem('sidebarCollapsed') === 'true' }"
      @sidebar-toggled.window="isCollapsed = $event.detail">

    <div class="flex min-h-screen">
        
        @include('partials.sidebar')

        {{-- md:ml-20 saat ciut, md:ml-72 saat buka --}}
        <main class="flex-1 transition-all duration-500 min-w-0 overflow-hidden"
              :class="isCollapsed ? 'md:ml-20' : 'md:ml-72'">
            
            <div class="p-0">
                @yield('content')
            </div>
            
        </main>
    </div>

    @stack('scripts')
</body>