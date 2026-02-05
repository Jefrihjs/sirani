<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'SIRANI')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f9fafb;
        }

        /* ===== CARD ===== */
        .card {
            background: #ffffff;
            padding: 16px;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,.1);
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            background: #111827;
            color: white;
            width: 220px;
            padding: 20px;
            transition: width .3s;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar ul li {
            margin-bottom: 10px;
        }

        .sidebar a,
        .menu-toggle {
            display: flex;
            align-items: center;
            gap: 10px;
            color: white;
            text-decoration: none;
            padding: 6px 0;
            cursor: pointer;
        }

        .sidebar a:hover {
            text-decoration: underline;
        }

        .icon svg {
            width: 20px;
            height: 20px;
            stroke: #e5e7eb;
        }

        .sidebar a:hover .icon svg {
            stroke: white;
        }

        /* ===== COLLAPSE ===== */
        .sidebar.collapsed {
            width: 70px;
            padding: 20px 8px;
        }

        .sidebar.collapsed .text {
            display: none;
        }

        .sidebar.collapsed a,
        .sidebar.collapsed .menu-toggle {
            justify-content: center;
        }

        /* ===== DROPDOWN NORMAL ===== */
        .submenu {
            display: none;
            margin-left: 34px;
            margin-top: 6px;
        }

        .submenu a {
            display: block;
            font-size: 14px;
            color: #d1d5db;
        }

        .submenu a:hover {
            color: white;
        }

        .menu-dropdown.open .submenu {
            display: block;
        }

        .caret {
            margin-left: auto;
            transition: transform .2s;
        }

        .menu-dropdown.open .caret {
            transform: rotate(90deg);
        }

        /* ===== POPUP MODE (COLLAPSE) ===== */
        .sidebar.collapsed #rekapSubmenu {
            position: fixed;
            left: 80px;
            background: #111827;
            padding: 8px 12px;
            border-radius: 8px;
            box-shadow: 0 8px 20px rgba(0,0,0,.35);
            z-index: 2000;
        }

        .sidebar.collapsed #rekapSubmenu a {
            white-space: nowrap;
        }

        /* ===== LOGO ===== */
        .logo-box {
            width: 36px;
            height: 36px;
            background: #6366f1;
            color: white;
            font-weight: bold;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .sidebar.collapsed .logo-text {
            display: none;
        }
    </style>
</head>

<body>

<!-- HEADER -->
<header style="background:#1f2937; color:white; padding:12px 20px;
               display:flex; justify-content:space-between; align-items:center;">

    <div style="display:flex;align-items:center;gap:12px;">
        <button onclick="toggleSidebar()"
                style="background:none;border:none;color:white;
                       font-size:22px;cursor:pointer;">
            ☰
        </button>
        <div class="logo-box">S</div>
        <strong class="logo-text">SIRANI</strong>
    </div>

    <!-- PROFILE -->
    <div style="position:relative;">
        <div onclick="toggleProfileMenu()"
             style="display:flex;align-items:center;gap:10px;cursor:pointer;">
            <img
                src="{{ auth()->user()->photo
                    ? asset('storage/' . auth()->user()->photo) . '?v=' . time()
                    : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) }}"
                style="width:36px;height:36px;
                    border-radius:50%;
                    object-fit:cover;">
            <span>{{ auth()->user()->name }}</span> ▾
        </div>

        <div id="profileMenu"
             style="display:none;position:absolute;right:0;top:48px;
                    background:white;color:#111;border-radius:8px;
                    box-shadow:0 5px 15px rgba(0,0,0,.15);
                    min-width:160px;overflow:hidden;z-index:1000;">
            <a href="{{ route('profil.asn') }}"
               style="display:block;padding:10px 15px;text-decoration:none;color:#111;">
                👤 Profil
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        style="width:100%;text-align:left;
                               padding:10px 15px;border:none;
                               background:none;cursor:pointer;">
                    🚪 Logout
                </button>
            </form>
        </div>
    </div>
</header>

<!-- BODY -->
<div style="display:flex;min-height:100vh;">

    <!-- SIDEBAR -->
    <aside id="sidebar" class="sidebar">
        <nav>
            <ul>

                <li>
                    <a href="{{ route('dashboard') }}">
                        <span class="icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12" />
                            </svg>
                        </span>
                        <span class="text">Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('laporan_kegiatan.index') }}">
                        <span class="icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M19.5 14.25V6a2.25 2.25 0 00-2.25-2.25H8.25A2.25 2.25 0 006 6v12a2.25 2.25 0 002.25 2.25h5.25" />
                            </svg>
                        </span>
                        <span class="text">Laporan Kegiatan</span>
                    </a>
                </li>

                <!-- REKAP DROPDOWN -->
                <li class="menu-dropdown" id="rekapItem">
                    <div class="menu-toggle" onclick="toggleRekap()">
                        <span class="icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M3 3v18h18M9 17V9m4 8v-5m4 5V7" />
                            </svg>
                        </span>
                        <span class="text">Rekap Laporan</span>
                        <span class="caret text">▸</span>
                    </div>

                    <div class="submenu" id="rekapSubmenu">
                        <a href="{{ route('laporan_kegiatan.rekap_triwulan') }}">Rekap Triwulan</a>
                        <a href="{{ route('laporan_kegiatan.rekap_tahunan') }}">Rekap Tahunan</a>
                    </div>
                </li>

                <li>
                    <a href="{{ route('master-kegiatan.index') }}">
                        <span class="icon">
                            <svg fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                      d="M2.25 6.75h7.5l2.25 3h9v9a2.25 2.25 0 01-2.25 2.25h-13.5A2.25 2.25 0 012.25 18V6.75z" />
                            </svg>
                        </span>
                        <span class="text">Master Kegiatan</span>
                    </a>
                </li>

            </ul>
        </nav>
    </aside>

    <!-- CONTENT -->
    <main style="flex:1;padding:20px;">
        @yield('content')
    </main>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('collapsed');
}

function toggleRekap() {
    const sidebar = document.getElementById('sidebar');
    const rekap = document.getElementById('rekapItem');
    const submenu = document.getElementById('rekapSubmenu');

    // COLLAPSE MODE → popup
    if (sidebar.classList.contains('collapsed')) {
        const rect = rekap.getBoundingClientRect();
        submenu.style.top = rect.top + 'px';
        submenu.style.display =
            submenu.style.display === 'block' ? 'none' : 'block';
        return;
    }

    // NORMAL MODE → dropdown
    rekap.classList.toggle('open');
}

function toggleProfileMenu() {
    const menu = document.getElementById('profileMenu');
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

// klik di luar → nutup
document.addEventListener('click', function(e) {
    const submenu = document.getElementById('rekapSubmenu');
    const rekap = document.getElementById('rekapItem');
    const profile = document.getElementById('profileMenu');

    if (!rekap.contains(e.target)) {
        submenu.style.display = 'none';
        rekap.classList.remove('open');
    }

    if (!e.target.closest('#profileMenu') &&
        !e.target.closest('[onclick="toggleProfileMenu()"]')) {
        profile.style.display = 'none';
    }
});
</script>

</body>
</html>
