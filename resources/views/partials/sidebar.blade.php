<aside class="sidebar">
    <div class="sidebar-content">
        <!-- Logo -->
        <img src="{{ asset('images/bigdashboard.svg') }}" alt="Logo" class="logo">

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Profile Section -->
        <div class="profile">
            <img src="{{ asset('images/default-photo.svg') }}" alt="User Photo" class="profile-photo">
            <div class="profile-info">
                <div class="profile-name">
                    {{ implode(' ', array_slice(explode(' ', $userName), 0, 2)) }}
                </div>
                <div class="profile-role">{{ $role }}</div>
            </div>
        </div>

        <!-- Divider -->
        <div class="divider"></div>

        <!-- Menu Items -->
        <div class="menu">
            <a href="{{ route('contacts.index') }}" class="menu-item" id="item-home">
                <img src="{{ asset('icons/home.svg') }}" alt="Home" class="menu-icon">
                <span class="menu-text">Beranda</span>
            </a>
            <a href="{{ route('data.tracker') }}" class="menu-item" id="item-tracker">
                <img src="{{ asset('icons/tracker.svg') }}" alt="Tracker" class="menu-icon">
                <span class="menu-text">Data Tracker</span>
            </a>
            <a href="{{ route('data.leads') }}" class="menu-item" id="item-leads">
                <img src="{{ asset('icons/leads.svg') }}" alt="Leads" class="menu-icon">
                <span class="menu-text">Leads</span>
            </a>
            <a href="" class="menu-item" id="item-log">
                <img src="{{ asset('icons/log.svg') }}" alt="Log" class="menu-icon">
                <span class="menu-text">Log Aktivitas</span>
            </a>
        </div>

        <!-- Settings and Logout -->
        <div class="settings">
            <a href="" class="settings-item" id="item-setting">
                <img src="{{ asset('icons/setting.svg') }}" alt="Settings" class="settings-icon">
                <span class="settings-text">Setting</span>
            </a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="settings-item" id="item-logout">
                    <img src="{{ asset('icons/logout.svg') }}" alt="Logout" class="settings-icon">
                    <span class="settings-text">Keluar</span>
                </button>
            </form>
        </div>
    </div>
</aside>

