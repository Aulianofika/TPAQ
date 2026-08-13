<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard - TPA Baitur Ridwan')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Epilogue:ital,wght@0,300..900;1,300..900&family=Manrope:wght@400;500;700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,700;1,400&family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap"
        rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --admin-bg: #FCF9F2;
            --admin-sidebar: #FCF9F2;
            --admin-primary: #064E3B;
            --admin-primary-light: rgba(6, 78, 59, 0.7);
            --admin-accent: #FED65B;
        }

        body {
            margin: 0;
            padding: 0;
            background-color: var(--admin-bg);
            font-family: 'Plus Jakarta Sans', sans-serif;
            color: #1C1C18;
            overflow-x: hidden;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Styling */
        .admin-sidebar {
            width: 250px;
            background: linear-gradient(135deg, #003227 0%, #004B3C 50%, #065F46 100%);
            display: flex;
            flex-direction: column;
            padding: 24px 0;
            flex-shrink: 0;
            border-right: 1px solid rgba(191, 201, 196, 0.4);
            position: fixed;
            height: 100vh;
            top: 0;
            left: 0;
            z-index: 50;
            box-shadow: 4px 0px 24px rgba(0, 0, 0, 0.02);
        }

        .sidebar-header {
            padding: 0 24px 32px;
        }

        .sidebar-brand {
            font-family: 'Epilogue', sans-serif;
            font-weight: 900;
            font-size: 20px;
            line-height: 28px;
            letter-spacing: -1px;
            color: #FED65B;
            margin: 0;
        }

        .sidebar-subtitle {
            font-family: 'Manrope', sans-serif;
            font-size: 10px;
            letter-spacing: 1px;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            margin: 0;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 4px;
            padding: 0 16px;
            flex-grow: 1;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 10px 16px;
            gap: 12px;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
            color: rgba(255, 255, 255, 0.8);
            font-family: 'Epilogue', sans-serif;
            font-weight: 500;
            font-size: 14px;
            position: relative;
            overflow: hidden;
        }

        .nav-link .material-symbols-outlined {
            font-size: 18px;
            color: rgba(255, 255, 255, 0.8);
            transition: transform 0.3s ease, color 0.3s ease;
        }

        .nav-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #FFFFFF;
            transform: translateX(4px);
        }

        .nav-link:hover .material-symbols-outlined {
            color: #FFFFFF;
            transform: scale(1.1);
        }

        .nav-group {
            display: flex;
            flex-direction: column;
            width: 100%;
        }

        .nav-submenu {
            display: flex;
            flex-direction: column;
            gap: 2px;
            padding-left: 36px;
            overflow: hidden;
            max-height: 0;
            transition: max-height 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .nav-submenu.open {
            max-height: 250px;
            /* high enough to show items */
            margin-top: 4px;
        }

        .submenu-link {
            padding: 8px 16px;
            font-size: 13px;
        }

        .nav-link.nav-group-toggle {
            background: transparent;
            border: none;
            width: 100%;
            cursor: pointer;
            text-align: left;
        }

        .nav-link.nav-group-toggle .expand-icon {
            margin-left: auto;
            transition: transform 0.3s ease;
        }

        .nav-group.open .expand-icon {
            transform: rotate(180deg);
        }

        .nav-link.active {
            background: #FED65B;
            color: #745C00;
            box-shadow: inset 0px 2px 4px rgba(0, 0, 0, 0.05);
            transform: translateX(0);
        }

        .nav-link.active .material-symbols-outlined {
            color: #745C00;
            transform: scale(1);
        }

        /* Profile Dropdown */
        .profile-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            margin-top: 8px;
            background: #FFFFFF;
            border-radius: 16px;
            box-shadow: 0px 10px 25px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(191, 201, 196, 0.4);
            width: 200px;
            padding: 8px;
            display: flex;
            flex-direction: column;
            gap: 4px;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-10px);
            transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
            z-index: 100;
        }

        .profile-dropdown.active {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-item {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            text-decoration: none;
            color: #DC2626;
            /* Red for logout */
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 600;
            font-size: 14px;
            border-radius: 12px;
            transition: background 0.2s;
        }

        .dropdown-item:hover {
            background: #FEF2F2;
        }

        .dropdown-item .material-symbols-outlined {
            font-size: 20px;
        }

        /* Sidebar Footer (Profile) */
        .sidebar-footer {
            padding: 24px 32px 0;
            border-top: 1px solid rgba(6, 78, 59, 0.05);
        }

        .profile-card {
            display: flex;
            align-items: center;
            padding: 16px;
            gap: 12px;
            background: #F6F3EC;
            border-radius: 48px;
        }

        .profile-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--admin-primary);
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: 700;
        }

        .profile-info {
            display: flex;
            flex-direction: column;
        }

        .profile-name {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            font-size: 12px;
            color: #003227;
        }

        .profile-role {
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 10px;
            color: #404945;
        }

        .admin-main {
            flex-grow: 1;
            margin-left: 250px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* TopAppBar / Header */
        .admin-topbar {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
            align-items: center;
            padding: 0 32px;
            height: 80px;
            background: rgba(252, 249, 242, 0.85);
            /* Matches #FCF9F2 */
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
            position: sticky;
            top: 0;
            z-index: 40;
            gap: 16px;
        }

        .menu-toggle {
            display: flex;
            background: none;
            border: none;
            color: #003227;
            cursor: pointer;
            padding: 8px;
            border-radius: 8px;
            align-items: center;
            justify-content: center;
            transition: background 0.2s;
        }

        .menu-toggle:hover {
            background: rgba(0, 50, 39, 0.05);
        }

        .search-container {
            display: flex;
            flex-direction: row;
            align-items: center;
            padding: 9px 24px 9px 16px;
            width: 300px;
            height: 40px;
            background: #FFFFFF;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 9999px;
            gap: 12px;
            transition: box-shadow 0.2s ease;
        }

        .search-container:focus-within {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        .search-icon {
            color: #A8A29E;
            font-size: 20px;
        }

        .search-input {
            border: none;
            background: transparent;
            outline: none;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 14px;
            color: #1C1C18;
            width: 100%;
        }

        .search-input::placeholder {
            color: #6B7280;
        }

        .topbar-right {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 24px;
        }

        .topbar-actions {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 16px;
        }

        .topbar-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 40px;
            height: 40px;
            border-radius: 9999px;
            background: transparent;
            border: none;
            cursor: pointer;
            color: #78716C;
            transition: background 0.2s;
        }

        .topbar-btn:hover {
            background: rgba(0, 0, 0, 0.05);
        }

        .topbar-divider {
            width: 1px;
            height: 32px;
            background: #E7E5E4;
        }

        .topbar-profile {
            display: flex;
            flex-direction: row;
            align-items: center;
            gap: 12px;
            cursor: pointer;
            padding: 6px 12px;
            border-radius: 9999px;
            transition: background 0.2s;
            position: relative;
        }

        .topbar-profile:hover {
            background: rgba(0, 0, 0, 0.03);
        }

        .topbar-profile-info {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
        }

        .topbar-name {
            font-family: 'Epilogue', sans-serif;
            font-weight: 700;
            font-size: 14px;
            color: #064E3B;
            margin: 0;
            line-height: 1;
        }

        .topbar-email {
            font-family: 'Manrope', sans-serif;
            font-weight: 400;
            font-size: 10px;
            color: #78716C;
            margin: 0;
            line-height: 1.5;
        }

        .topbar-avatar {
            width: 40px;
            height: 40px;
            background: #004B3C;
            border: 2px solid #FFFFFF;
            box-shadow: 0px 1px 2px rgba(0, 0, 0, 0.05);
            border-radius: 9999px;
            display: flex;
            justify-content: center;
            align-items: center;
            color: white;
            font-weight: bold;
        }

        .content-wrapper {
            padding: 32px;
            flex-grow: 1;
        }

        /* Sidebar Overlay */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.4);
            z-index: 45;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .sidebar-overlay.active {
            display: block;
            opacity: 1;
        }

        /* Collapsed Sidebar State (Desktop) */
        .admin-sidebar {
            transition: width 0.3s cubic-bezier(0.4, 0, 0.2, 1), transform 0.3s ease-in-out;
            overflow-x: hidden;
        }

        .sidebar-collapsed .admin-sidebar {
            width: 72px;
        }

        .sidebar-collapsed .admin-sidebar .sidebar-brand {
            font-size: 14px;
            text-align: center;
        }

        .sidebar-collapsed .admin-sidebar .sidebar-subtitle,
        .sidebar-collapsed .admin-sidebar .nav-section-title,
        .sidebar-collapsed .admin-sidebar .nav-link span:not(.material-symbols-outlined) {
            display: none;
        }

        .sidebar-collapsed .admin-sidebar .nav-link {
            justify-content: center;
            padding: 12px;
        }

        .sidebar-collapsed .admin-sidebar .nav-group-toggle .expand-icon {
            display: none;
        }

        .sidebar-collapsed .admin-sidebar .nav-submenu {
            padding-left: 0;
            align-items: center;
        }

        .sidebar-collapsed .admin-sidebar .submenu-link {
            justify-content: center;
            padding: 12px;
        }

        .sidebar-collapsed .admin-sidebar .sidebar-header {
            padding: 0 12px 32px;
            text-align: center;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
        }

        .admin-main {
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .sidebar-collapsed .admin-main {
            margin-left: 72px;
        }

        /* Responsive Design */
        @media (max-width: 1024px) {
            .admin-sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease-in-out;
                z-index: 50;
                width: 250px !important;
                /* Force width on mobile */
            }

            .admin-sidebar.active {
                transform: translateX(0);
            }

            .admin-sidebar .sidebar-subtitle,
            .admin-sidebar .nav-link span:not(.material-symbols-outlined) {
                display: block;
                /* Ensure text is visible on mobile */
            }

            .admin-sidebar .nav-link {
                justify-content: flex-start;
                padding: 10px 16px;
            }

            .admin-sidebar .sidebar-brand {
                font-size: 20px;
                text-align: left;
                color: #FED65B;
            }

            .admin-sidebar .sidebar-header {
                padding: 0 24px 32px;
                align-items: flex-start;
            }

            .admin-main {
                margin-left: 0;
            }

            .admin-main.collapsed {
                margin-left: 0;
            }

            .search-container {
                width: 200px;
            }
        }

        @media (max-width: 768px) {
            .admin-topbar {
                padding: 0 16px;
            }

            .search-container {
                display: none;
                /* Hide search on mobile for cleaner topbar */
            }

            .topbar-profile-info {
                display: none;
                /* Hide name/email on very small screens */
            }

            .topbar-right {
                gap: 8px;
            }

            .content-wrapper {
                padding: 16px;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    <script>
        // Set sidebar state early to prevent flickering
        if (localStorage.getItem('sidebarState') === 'collapsed' && window.innerWidth > 1024) {
            document.body.classList.add('sidebar-collapsed');
        }
    </script>

    <!-- Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <div class="admin-layout">
        <!-- Sidebar Navigation -->
        <aside class="admin-sidebar">
            <div class="sidebar-header" style="display: flex; align-items: center; gap: 12px; padding: 0 24px 32px;">
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo TPA" style="width: 42px; height: 42px; border-radius: 50%; object-fit: cover; border: 2px solid #FED65B; background-color: #ffffff; flex-shrink: 0;">
                <div>
                    <h1 class="sidebar-brand" style="font-size: 18px; line-height: 1.2;">Baitur Ridwan</h1>
                    <p class="sidebar-subtitle" style="font-size: 8px;">Taman Pendidikan Al-Qur'an</p>
                </div>
            </div>

            <nav class="sidebar-nav">
                <!-- Bagian Guru & Admin -->
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-link {{ Route::currentRouteName() == 'admin.dashboard' ? 'active' : '' }}">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a href="{{ route('admin.absensi') }}"
                    class="nav-link {{ request()->routeIs('admin.absensi') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">event_available</span>
                    <span>Input Absensi</span>
                </a>


                <a href="{{ route('admin.eraport') }}"
                    class="nav-link {{ request()->routeIs('admin.eraport') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">school</span>
                    <span>Input E-Rapor</span>
                </a>

                <a href="{{ route('admin.hafalan') }}"
                    class="nav-link {{ request()->routeIs('admin.hafalan') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">menu_book</span>
                    <span>Progres Hafalan</span>
                </a>

                <a href="{{ route('admin.santri.progress') }}"
                    class="nav-link {{ request()->routeIs('admin.santri.progress*') ? 'active' : '' }}">
                    <span class="material-symbols-outlined">trending_up</span>
                    <span>Perkembangan Santri</span>
                </a>

                <!-- Dropdown Laporan & Rekap -->
                @php
                    $isRekapActive = request()->routeIs('admin.absensi.rekap') || request()->routeIs('admin.eraport.riwayat') || request()->routeIs('admin.iuran.rekap');
                @endphp
                <div class="nav-group {{ $isRekapActive ? 'open' : '' }}" id="rekapNavGroup">
                    <button type="button" class="nav-link nav-group-toggle" id="rekapToggleBtn">
                         <span class="material-symbols-outlined">folder_open</span>
                         <span>Laporan & Rekap</span>
                         <span class="material-symbols-outlined expand-icon">expand_more</span>
                    </button>
                    <div class="nav-submenu {{ $isRekapActive ? 'open' : '' }}" id="rekapSubmenu">
                        <a href="{{ route('admin.absensi.rekap') }}"
                            class="nav-link submenu-link {{ request()->routeIs('admin.absensi.rekap') ? 'active' : '' }}">
                            <span class="material-symbols-outlined">calendar_month</span>
                            <span>Rekap Absensi</span>
                        </a>
                        <a href="{{ route('admin.eraport.riwayat') }}"
                            class="nav-link submenu-link {{ request()->routeIs('admin.eraport.riwayat') ? 'active' : '' }}">
                            <span class="material-symbols-outlined">history</span>
                            <span>Rekap Raport</span>
                        </a>
                        <a href="{{ route('admin.iuran.rekap') }}"
                            class="nav-link submenu-link {{ request()->routeIs('admin.iuran.rekap') ? 'active' : '' }}">
                            <span class="material-symbols-outlined">request_quote</span>
                            <span>Rekap Iuran</span>
                        </a>
                    </div>
                </div>

                <!-- Bagian Khusus Admin -->
                @if(auth()->check() && auth()->user()->role === 'admin')
                    <div class="nav-section-title"
                        style="margin: 12px 16px 4px; font-size: 10px; font-weight: 700; color: rgba(255,255,255,0.4); text-transform: uppercase; letter-spacing: 1px;">
                        Kelola Data
                    </div>
                    <a href="{{ route('admin.kelas.index') }}"
                        class="nav-link {{ Route::currentRouteName() == 'admin.kelas.index' ? 'active' : '' }}">
                        <span class="material-symbols-outlined">class</span>
                        <span>Data Kelas</span>
                    </a>
                    <a href="{{ route('admin.santri.index') }}"
                        class="nav-link {{ Route::currentRouteName() == 'admin.santri.index' ? 'active' : '' }}">
                        <span class="material-symbols-outlined">group</span>
                        <span>Santri</span>
                    </a>
                    <a href="{{ route('admin.pengajar') }}"
                        class="nav-link {{ Route::currentRouteName() == 'admin.pengajar' ? 'active' : '' }}">
                        <span class="material-symbols-outlined">local_library</span>
                        <span>Data Guru</span>
                    </a>
                    <a href="{{ route('admin.pengurus') }}"
                        class="nav-link {{ Route::currentRouteName() == 'admin.pengurus' ? 'active' : '' }}">
                        <span class="material-symbols-outlined">shield_person</span>
                        <span>Data Pengurus</span>
                    </a>
                    <a href="{{ route('admin.iuran') }}"
                        class="nav-link {{ request()->routeIs('admin.iuran') ? 'active' : '' }}">
                        <span class="material-symbols-outlined">payments</span>
                        <span>Pembayaran Iuran</span>
                    </a>
                    <a href="{{ route('admin.galeri') }}"
                        class="nav-link {{ Route::currentRouteName() == 'admin.galeri' ? 'active' : '' }}">
                        <span class="material-symbols-outlined">photo_library</span>
                        <span>Galeri</span>
                    </a>
                    <a href="{{ route('admin.pengumuman') }}"
                        class="nav-link {{ Route::currentRouteName() == 'admin.pengumuman' ? 'active' : '' }}">
                        <span class="material-symbols-outlined">campaign</span>
                        <span>Pengumuman</span>
                    </a>
                @endif
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="admin-main">
            <!-- TopAppBar -->
            <header class="admin-topbar">
                <div style="display: flex; align-items: center; gap: 16px;">
                    <button class="menu-toggle" id="menuToggle">
                        <span class="material-symbols-outlined">menu_open</span>
                    </button>


                </div>

                <div class="topbar-right">

                    <div class="topbar-profile" id="profileDropdownBtn">
                        <div class="topbar-profile-info" >
                            <span class="topbar-name">Assalamu'alaikum, {{ explode(' ', auth()->user()->name ?? 'Admin')[0] }}</span>
                            <span class="topbar-email">{{ auth()->user()->email ?? 'admin@baiturridwan.com' }}</span>
                        </div>
                        <div class="topbar-avatar" style="background: linear-gradient(135deg, #004B3C 0%, #065F46 100%);">
                            {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                        </div>

                        <!-- Dropdown Menu -->
                        <div class="profile-dropdown" id="profileDropdown">
                            <div style="padding: 12px 16px; border-bottom: 1px solid rgba(0,0,0,0.05); margin-bottom: 4px;">
                                <span style="display: block; font-family: 'Epilogue', sans-serif; font-size: 14px; font-weight: 700; color: #003227;">{{ auth()->user()->name ?? 'Admin Utama' }}</span>
                                <span style="display: block; font-family: 'Plus Jakarta Sans', sans-serif; font-size: 11px; color: #78716C; text-transform: capitalize;">{{ auth()->user()->role ?? 'Administrator' }}</span>
                            </div>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="margin:0; padding:0;" onsubmit="confirmLogout(event)">
                                @csrf
                                <button type="submit" class="dropdown-item"
                                    style="width: 100%; border: none; background: transparent; cursor: pointer; text-align: left; font-family: inherit; margin-top: 4px;">
                                    <span class="material-symbols-outlined">logout</span>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                @yield('content')
            </div>
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.querySelector('.admin-sidebar');
            const adminMain = document.querySelector('.admin-main');
            const menuToggle = document.getElementById('menuToggle');
            const overlay = document.getElementById('sidebarOverlay');

            function toggleSidebar() {
                if (window.innerWidth <= 1024) {
                    sidebar.classList.toggle('active');
                    overlay.classList.toggle('active');
                    // Prevent body scroll when sidebar is open on mobile
                    if (sidebar.classList.contains('active')) {
                        document.body.style.overflow = 'hidden';
                    } else {
                        document.body.style.overflow = '';
                    }
                } else {
                    document.body.classList.toggle('sidebar-collapsed');
                    
                    // Simpan preferensi pengguna ke localStorage
                    if (document.body.classList.contains('sidebar-collapsed')) {
                        localStorage.setItem('sidebarState', 'collapsed');
                    } else {
                        localStorage.setItem('sidebarState', 'expanded');
                    }
                }
            }

            menuToggle.addEventListener('click', toggleSidebar);
            overlay.addEventListener('click', toggleSidebar);

            // Close sidebar when clicking a link (optional, good for mobile)
            const navLinks = document.querySelectorAll('.nav-link');
            navLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (window.innerWidth <= 1024) {
                        sidebar.classList.remove('active');
                        overlay.classList.remove('active');
                        document.body.style.overflow = '';
                    }
                });
            });

            // Handle window resize
            window.addEventListener('resize', () => {
                if (window.innerWidth > 1024) {
                    sidebar.classList.remove('active');
                    overlay.classList.remove('active');
                    document.body.style.overflow = '';
                }
            });

            // Profile Dropdown Toggle
            const profileBtn = document.getElementById('profileDropdownBtn');
            const profileDropdown = document.getElementById('profileDropdown');

            profileBtn.addEventListener('click', (e) => {
                e.stopPropagation(); // Prevent closing immediately
                profileDropdown.classList.toggle('active');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', (e) => {
                if (!profileBtn.contains(e.target)) {
                    profileDropdown.classList.remove('active');
                }
            });

            // Sidebar Accordion Toggle
            const rekapToggleBtn = document.getElementById('rekapToggleBtn');
            const rekapNavGroup = document.getElementById('rekapNavGroup');
            const rekapSubmenu = document.getElementById('rekapSubmenu');

            if (rekapToggleBtn) {
                rekapToggleBtn.addEventListener('click', () => {
                    rekapNavGroup.classList.toggle('open');
                    rekapSubmenu.classList.toggle('open');
                });
            }
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmLogout(event) {
            event.preventDefault();
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan keluar dari sesi ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#064E3B',
                cancelButtonColor: '#DC2626',
                confirmButtonText: 'Ya, keluar!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }
    </script>
    @stack('scripts')
</body>

</html>