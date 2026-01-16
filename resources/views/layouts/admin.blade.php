<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'Admin Dashboard')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- FontAwesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <!-- Custom -->
    <link rel="stylesheet" href="{{ asset('assets/css/styles.css') }}">
</head>
<body>

{{-- MOBILE SIDEBAR --}}
<div class="offcanvas offcanvas-start" tabindex="-1" id="mobileSidebar">
    <div class="offcanvas-header border-bottom">
        <img width="80" src="{{ asset('assets/images/Logo-print-artwork-final-c1.png') }}">
        <button class="btn-close" data-bs-dismiss="offcanvas"></button>
    </div>
    <div class="offcanvas-body p-0">
        <ul class="nav flex-column p-3 gap-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                   href="{{ route('dashboard') }}">
                   <i class="fa fa-gauge me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mt-3 fw-semibold text-muted">Inventory</li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('motorcycles.index') ? 'active' : '' }}" 
                   href="{{ route('motorcycles.index') }}">
                   <i class="fa fa-motorcycle me-2"></i> Motorcycle
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('motorcycles.create') ? 'active' : '' }}" 
                   href="{{ route('motorcycles.create') }}">
                   <i class="fa fa-plus me-2"></i> Add Motorcycle
                </a>
            </li>

            <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-plus me-2"></i> Add On</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-plus me-2"></i> Brands</a></li>
        </ul>
    </div>
</div>

<div class="d-flex">

    {{-- DESKTOP SIDEBAR --}}
    <aside class="border-end d-none d-lg-block" style="min-width:260px; min-height:100vh;">
        <div class="pb-2 text-center border-bottom">
            <img width="85" src="{{ asset('assets/images/Logo-print-artwork-final-c1.png') }}">
        </div>

        <ul class="nav flex-column p-3 gap-1">
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                   href="{{ route('dashboard') }}">
                   <i class="fa fa-gauge me-2"></i> Dashboard
                </a>
            </li>

            <li class="nav-item mt-3 fw-semibold text-muted">Inventory</li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('motorcycles.index') ? 'active' : '' }}" 
                href="{{ route('motorcycles.index') }}">
                <i class="fa fa-motorcycle me-2"></i> Motorcycle
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('motorcycles.create') ? 'active' : '' }}" 
                href="{{ route('motorcycles.create') }}">
                <i class="fa fa-plus me-2"></i> Add Motorcycle
                </a>
            </li>

            <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-plus me-2"></i> Add On</a></li>
            <li class="nav-item"><a class="nav-link" href="#"><i class="fa fa-plus me-2"></i> Brands</a></li>
        </ul>
    </aside>

    {{-- MAIN --}}
    <div class="flex-grow-1">

        {{-- TOPBAR --}}
        <header class="d-flex justify-content-between align-items-center p-3 border-bottom">
            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-outline-secondary d-lg-none"
                        data-bs-toggle="offcanvas"
                        data-bs-target="#mobileSidebar">
                    <i class="fa fa-bars"></i>
                </button>
                <h5 class="mb-0">@yield('page-title')</h5>
            </div>

            <div class="d-flex align-items-center gap-3">
                <button id="ld-theme" class="btn btn-outline-secondary rounded-circle">
                    <i id="theme-icon" class="fa fa-sun"></i>
                </button>

            <div class="dropdown">
                <a class="dropdown-toggle text-decoration-none" href="#" data-bs-toggle="dropdown">
                    <strong>{{ Auth::user()->name }}</strong><br>
                    <small class="text-muted">Super Admin</small>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                            <i class="fa fa-user me-2"></i> Profile
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="dropdown-item text-danger">
                                <i class="fa fa-sign-out-alt me-2"></i> Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>

            </div>
        </header>

        {{-- CONTENT --}}
        <main class="p-3 p-md-4">
            @yield('content')
        </main>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<script>
const html = document.documentElement;
const themeIcon = document.getElementById('theme-icon');

function updateIcon() {
    themeIcon.className = html.getAttribute('data-bs-theme') === 'dark'
        ? 'fa fa-moon'
        : 'fa fa-sun';
}

document.getElementById('ld-theme').onclick = () => {
    const t = html.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
    html.setAttribute('data-bs-theme', t);
    localStorage.setItem('theme', t);
    updateIcon();
};

html.setAttribute('data-bs-theme', localStorage.getItem('theme') || 'dark');
updateIcon();
</script>

@stack('scripts')
</body>
</html>

<style>
.nav-link {
    border-radius: 10px;
    padding: 10px 14px;
    color: var(--bs-body-color);
}

.nav-link.active {
    background: #facc15;
    color: #000 !important;
    font-weight: 600;
}

.nav-link.active i {
    color: #000;
}
</style>
