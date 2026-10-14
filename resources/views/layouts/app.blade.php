<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') · WrenchWorks</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --ink: #152238; --muted: #68778d; --accent: #e85d2a; --canvas: #f4f6fa; }
        body { background: var(--canvas); color: var(--ink); }
        .navbar { background: #152238; }
        .navbar-brand { font-weight: 800; letter-spacing: -.04em; }
        .brand-mark { color: #ff875d; }
        .nav-link { color: #dce3ed; }
        .nav-link:hover, .nav-link.active { color: #ff9a72; }
        .page-title { font-weight: 800; letter-spacing: -.04em; }
        .card { border: 1px solid #e6eaf0; border-radius: 1rem; box-shadow: 0 8px 24px rgba(24, 39, 61, .04); }
        .stat-number { font-size: 2rem; font-weight: 800; }
        .text-muted { color: var(--muted) !important; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #cf4c1e; border-color: #cf4c1e; }
        .table > :not(caption) > * > * { padding: .9rem .75rem; }
        .form-label { font-weight: 650; }
    </style>
    @stack('styles')
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark">
    <div class="container">
        <a class="navbar-brand" href="{{ route('dashboard') }}"><span class="brand-mark">W</span>renchWorks</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <div class="navbar-nav ms-auto">
                <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}">Dashboard</a>
                <a class="nav-link {{ request()->routeIs('customers.*') ? 'active' : '' }}" href="{{ route('customers.index') }}">Customers</a>
                <a class="nav-link {{ request()->routeIs('vehicles.*') ? 'active' : '' }}" href="{{ route('vehicles.index') }}">Vehicles</a>
                <a class="nav-link {{ request()->routeIs('mechanics.*') ? 'active' : '' }}" href="{{ route('mechanics.index') }}">Mechanics</a>
                <a class="nav-link {{ request()->routeIs('repair-jobs.*') ? 'active' : '' }}" href="{{ route('repair-jobs.index') }}">Repair jobs</a>
                <a class="nav-link {{ request()->routeIs('parts.*') ? 'active' : '' }}" href="{{ route('parts.index') }}">Parts</a>
            </div>
        </div>
    </div>
</nav>
<main class="container py-4 py-lg-5">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger" role="alert">
            <strong>Please correct the following:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @yield('content')
</main>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
