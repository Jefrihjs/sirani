<header class="header">
    <div class="header-left">
        <button class="burger" onclick="toggleSidebar()">☰</button>
        <h1>@yield('page_title','Dashboard')</h1>
    </div>

    <div class="header-right">
        <div class="profile" onclick="toggleProfileMenu()">
            <img src="{{ auth()->user()->photo
                ? asset('storage/'.auth()->user()->photo)
                : 'https://ui-avatars.com/api/?name='.urlencode(auth()->user()->name) }}">
            <span>{{ auth()->user()->name }}</span>
        </div>

        <div id="profileMenu" class="profile-menu">
            <a href="{{ route('profil.asn') }}">Profil ASN</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit">Logout</button>
            </form>
        </div>
    </div>
</header>