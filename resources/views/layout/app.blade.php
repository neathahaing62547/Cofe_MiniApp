<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Coffee System')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&family=DM+Sans:wght@300;400;500&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>

<body>

    {{-- TOP NAVBAR --}}
    <nav class="navbar">
        <div class="navbar-brand">
            <img src="{{ asset('storage/default/logo.png') }}" alt="Coffee System Logo" class="logo">
            <span class="brand-name">Coffee System</span>
        </div>
        <div class="navbar-right">
            <div class="navbar-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(auth()->user()->username ?? 'A', 0, 1)) }}
                </div>
                <span class="user-name">{{ auth()->user()->username ?? 'Admin' }}</span>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-logout">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" y1="12" x2="9" y2="12" />
                    </svg>
                    Logout
                </button>
            </form>
        </div>
    </nav>

    <div class="layout">

        {{-- SIDEBAR --}}
        <aside class="sidebar">
            <nav class="sidebar-nav">
                <a href="{{ route('dashboard') }}"
                    class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <rect x="3" y="3" width="7" height="7" />
                        <rect x="14" y="3" width="7" height="7" />
                        <rect x="14" y="14" width="7" height="7" />
                        <rect x="3" y="14" width="7" height="7" />
                    </svg>
                    Dashboard
                </a>
                <a href="{{ route('product_page') }}"
                    class="nav-item {{ request()->routeIs('product_page') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z" />
                        <line x1="3" y1="6" x2="21" y2="6" />
                        <path d="M16 10a4 4 0 01-8 0" />
                    </svg>
                    Products
                </a>
                <a href="{{ route('order_page') }}"
                    class="nav-item {{ request()->routeIs('order_page') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z" />
                        <polyline points="14 2 14 8 20 8" />
                        <line x1="16" y1="13" x2="8" y2="13" />
                        <line x1="16" y1="17" x2="8" y2="17" />
                        <polyline points="10 9 9 9 8 9" />
                    </svg>
                    Orders
                </a>
                <a href="{{ route('product_category') }}"
                    class="nav-item {{ request()->routeIs('categories*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M20.59 13.41L11 3 3 11l9.59 9.59a2 2 0 002.82 0l5.18-5.18a2 2 0 000-2.82z" />
                        <circle cx="7.5" cy="7.5" r="1.5" />
                    </svg>
                    Categories
                </a>
                <a href="{{ route('customers.index') }}"
                    class="nav-item {{ request()->routeIs('customers*') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5">
                        <path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" />
                        <circle cx="9" cy="7" r="4" />
                        <path d="M23 21v-2a4 4 0 00-3-3.87" />
                        <path d="M16 3.13a4 4 0 010 7.75" />
                    </svg>
                    Customers
                </a>
                <a href="{{ route('reports') }}" class="nav-item {{ request()->routeIs('reports') ? 'active' : '' }}">
                    <svg class="nav-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="1.5">
                        <line x1="18" y1="20" x2="18" y2="10" />
                        <line x1="12" y1="20" x2="12" y2="4" />
                        <line x1="6" y1="20" x2="6" y2="14" />
                    </svg>
                    Reports
                </a>
            </nav>

            <div class="sidebar-footer">
                <div class="sidebar-version">v1.0.0</div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <main class="main">
            {{-- PAGE HEADER --}}
            @hasSection('page-header')
                <div class="page-header">
                    <div>
                        <h1 class="page-title">@yield('page-title')</h1>
                        <p class="page-subtitle">@yield('page-subtitle')</p>
                    </div>
                    <div class="page-actions">
                        @yield('page-actions')
                    </div>
                </div>
            @endif

            {{-- FLASH MESSAGES --}}
            @if (session('success'))
                <div id="success" class="alert alert-success">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <polyline points="20 6 9 17 4 12" />
                    </svg>
                    {{ session('success') }}
                </div>
                <script>
                    setTimeout(function() {
                        document.getElementById('success').style.display = 'none';
                    }, 2000);
                </script>
            @endif
            @if (session('error'))
                <div class="alert alert-error">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2">
                        <circle cx="12" cy="12" r="10" />
                        <line x1="12" y1="8" x2="12" y2="12" />
                        <line x1="12" y1="16" x2="12.01" y2="16" />
                    </svg>
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </main>

    </div>

    @stack('scripts')

</body>

</html>
