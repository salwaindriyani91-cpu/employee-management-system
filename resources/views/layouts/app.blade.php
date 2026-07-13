<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') - EMS Portal</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        :root{
            --deep:#274472;
            --navy:#3d6299;
            --blue:#6ea8e0;
            --blue-light:#a9cdf0;
            --sky:#dceafb;
            --text:#3a4a63;
            --brand-tint:#eaf3fd;
            --bg:#eef5fd;
            --border:#dbe8f7;
            --text-muted:#8296b3;
        }
        *{box-sizing:border-box;}
        body{font-family:'Poppins',-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;background:linear-gradient(160deg,#eaf3fd 0%, #d3e6fa 55%, #c3daf5 100%);margin:0;color:var(--deep);}
        .app-frame{display:flex;min-height:100vh;}

        /* Sidebar - calm translucent light blue, same family as the login card */
        /* Sticky di atas: sidebar tetap terlihat & tidak ikut ter-scroll saat konten halaman panjang */
        .sidebar{width:250px;flex-shrink:0;position:sticky;top:0;align-self:flex-start;height:100vh;overflow-y:auto;overflow-x:hidden;background:linear-gradient(180deg,#eaf3fd 0%,#d3e6fa 55%,#c3daf5 100%);border-right:1px solid rgba(255,255,255,.6);display:flex;flex-direction:column;color:var(--deep);}
        .sidebar-deco{position:absolute;inset:0;width:100%;height:100%;pointer-events:none;z-index:0;}
        .sidebar > *:not(.sidebar-deco){position:relative;z-index:1;}
        .brand{display:flex;align-items:center;gap:10px;padding:22px 20px;}
        .brand .logo-mark{width:36px;height:36px;border-radius:10px;background:linear-gradient(135deg,var(--blue-light),var(--blue));display:flex;align-items:center;justify-content:center;color:#fff;font-weight:800;font-size:.85rem;flex-shrink:0;box-shadow:0 6px 14px rgba(110,168,224,.4);}
        .brand span{font-size:1rem;font-weight:800;color:var(--deep);}
        .sidebar-section-label{padding:16px 20px 6px;font-size:.66rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:#6f89ab;}
        .nav-link-custom{display:flex;align-items:center;gap:11px;margin:2px 12px;padding:10px 12px;border-radius:10px;color:var(--text);font-weight:500;font-size:.87rem;text-decoration:none;}
        .nav-link-custom i{width:16px;text-align:center;font-size:1rem;color:var(--navy);}
        .nav-link-custom:hover{background:rgba(255,255,255,.5);color:var(--deep);}
        .nav-link-custom:hover i{color:var(--deep);}
        .nav-link-custom.active{background:linear-gradient(135deg,var(--blue-light),var(--blue));color:#fff;box-shadow:0 8px 18px rgba(110,168,224,.35);}
        .nav-link-custom.active i{color:#fff;}
        /* Do not force the nav to stretch; keep it sized to content so the user-box sits just below it */
        .sidebar-nav{padding:6px 0 10px;}
        .user-box{margin:10px 12px 18px;padding:11px;border-radius:14px;background:rgba(255,255,255,.5);border:1px solid rgba(255,255,255,.7);display:flex;align-items:center;gap:9px;}
        .user-box .name{font-size:.82rem;font-weight:600;color:var(--deep);line-height:1.2;}
        .user-box .role{font-size:.71rem;color:var(--text-muted);}
        .avatar{width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--blue-light),var(--blue));color:#fff;display:flex;align-items:center;justify-content:center;font-size:.78rem;font-weight:700;flex-shrink:0;}
        .logout-btn{margin-left:auto;background:none;border:none;color:var(--text-muted);padding:4px;}
        .logout-btn:hover{color:#d43a55;}

        .main{flex:1;min-width:0;display:flex;flex-direction:column;}
        .topbar{display:flex;align-items:center;justify-content:space-between;padding:18px 28px;background:transparent;}
        .topbar h1{font-size:1.2rem;font-weight:800;margin:0;color:var(--deep);}
        .content{padding:0 28px 28px;flex:1;}

        .card-panel{background:#fff;border-radius:16px;border:1px solid var(--border);}
        .stat-card{background:#fff;border-radius:16px;border:1px solid var(--border);padding:18px 20px;height:100%;position:relative;overflow:hidden;}
        .stat-icon{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:1.05rem;margin-bottom:12px;}
        .icon-blue{background:var(--brand-tint);color:var(--blue);}
        .icon-green{background:#e4f8ef;color:#0fa85e;}
        .icon-amber{background:#fef3e2;color:#d68b0d;}
        .icon-red{background:#fde9ec;color:#d43a55;}
        .stat-label{color:var(--text-muted);font-size:.82rem;}
        .stat-value{font-size:1.6rem;font-weight:800;color:var(--deep);}

        .table thead th{font-size:.72rem;text-transform:uppercase;letter-spacing:.03em;color:var(--text-muted);border-bottom:1px solid var(--border);font-weight:700;background:#fafbff;}
        .table td{vertical-align:middle;font-size:.88rem;}
        .btn-brand{background:linear-gradient(135deg,var(--blue-light),var(--blue));border:none;color:#fff;font-weight:600;box-shadow:0 8px 18px rgba(110,168,224,.35);}
        .btn-brand:hover{filter:brightness(1.05);color:#fff;}
        .status-pill{font-size:.72rem;padding:3px 10px;border-radius:20px;font-weight:600;}
        .status-Aktif{background:#e4f8ef;color:#0fa85e;}
        .status-Nonaktif{background:#fde9ec;color:#d43a55;}
        .status-Cuti{background:#fef3e2;color:#d68b0d;}

        .welcome-banner{
            background:linear-gradient(120deg,#a9cdf0 0%,#6ea8e0 55%,#5f93cf 100%);
            border-radius:18px;color:#fff;padding:28px 30px;position:relative;overflow:hidden;margin-bottom:22px;
        }
        .welcome-banner h2{font-weight:800;font-size:1.3rem;margin-bottom:6px;}
        .welcome-banner p{color:#eaf3fd;font-size:.87rem;margin-bottom:0;max-width:520px;}
        .welcome-banner .deco-svg{position:absolute;right:0;top:0;height:100%;opacity:.9;}
        .role-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(255,255,255,.22);border:1px solid rgba(255,255,255,.4);padding:4px 12px;border-radius:20px;font-size:.72rem;font-weight:600;margin-bottom:12px;}
    </style>
    @stack('styles')
</head>
<body>
<div class="app-frame">
    <aside class="sidebar">
        <svg class="sidebar-deco" viewBox="0 0 250 800" preserveAspectRatio="xMidYMax slice" xmlns="http://www.w3.org/2000/svg">
            <circle cx="220" cy="60" r="110" fill="#ffffff" opacity="0.3"/>
            <circle cx="30" cy="380" r="70" fill="#ffffff" opacity="0.25"/>
            <path d="M0,600 C60,570 90,630 60,660 C35,685 5,665 20,635" stroke="#ffffff" stroke-width="3" fill="none" opacity="0.4" stroke-linecap="round"/>
            <path d="M120,740 C155,715 200,735 185,770" stroke="#ffffff" stroke-width="3" fill="none" opacity="0.4" stroke-linecap="round"/>
            <g opacity="0.45" fill="#ffffff">
                <circle cx="190" cy="700" r="2.5"/><circle cx="205" cy="712" r="2.5"/><circle cx="220" cy="700" r="2.5"/>
                <circle cx="190" cy="724" r="2.5"/><circle cx="205" cy="736" r="2.5"/><circle cx="220" cy="724" r="2.5"/>
            </g>
        </svg>
        <div class="brand">
            <div class="logo-mark"><img src="{{ asset('images/logo.svg') }}" alt="Logo" style="width:22px;height:22px;object-fit:contain;"></div>
            <span>EMS Portal</span>
        </div>
        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Menu</div>
            <a href="{{ route('dashboard') }}" class="nav-link-custom {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>
            <a href="{{ route('karyawan.index') }}" class="nav-link-custom {{ request()->routeIs('karyawan.*') && !request()->routeIs('karyawan.profile.*') && !request()->routeIs('karyawan.payslip') ? 'active' : '' }}">
                <i class="bi bi-{{ auth()->user()?->isAdmin() ? 'people' : 'search' }}"></i> {{ auth()->user()?->isAdmin() ? 'Karyawan' : 'Cari Rekan Kerja' }}
            </a>
            @if(auth()->user()?->isAdmin())
                <a href="{{ route('departemen.index') }}" class="nav-link-custom {{ request()->routeIs('departemen.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i> Departemen
                </a>
                <a href="{{ route('laporan.index') }}" class="nav-link-custom {{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart"></i> Laporan
                </a>
                <a href="{{ route('karyawan.import.form') }}" class="nav-link-custom {{ request()->routeIs('karyawan.import.*') || request()->routeIs('karyawan.export.*') ? 'active' : '' }}">
                    <i class="bi bi-arrow-left-right"></i> Impor / Ekspor
                </a>
            @else
                <a href="{{ route('karyawan.payslip') }}" class="nav-link-custom {{ request()->routeIs('karyawan.payslip') ? 'active' : '' }}">
                    <i class="bi bi-cash-coin"></i> Slip Gaji
                </a>
                <a href="{{ route('karyawan.profile.edit') }}" class="nav-link-custom {{ request()->routeIs('karyawan.profile.*') ? 'active' : '' }}">
                    <i class="bi bi-person-lines-fill"></i> Data Diri
                </a>
            @endif

            <div class="sidebar-section-label">Akun</div>
            <a href="{{ route('profile.edit') }}" class="nav-link-custom {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-gear"></i> Pengaturan
            </a>
        </nav>
        <div class="user-box">
            <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
            <div>
                <div class="name">{{ auth()->user()->name ?? 'Pengguna' }}</div>
                <div class="role">{{ auth()->user()?->isAdmin() ? 'Administrator' : 'Karyawan' }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="logout-btn">
                @csrf
                <button type="submit" class="logout-btn" title="Keluar"><i class="bi bi-box-arrow-right"></i></button>
            </form>
        </div>
    </aside>

    <div class="main">
        <div class="topbar">
            <h1>@yield('page-title', 'Dashboard')</h1>
            <div class="dropdown">
                <a href="#" class="d-flex align-items-center text-decoration-none" data-bs-toggle="dropdown">
                    <div class="avatar">{{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}</div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><span class="dropdown-item-text small text-muted">{{ auth()->user()?->isAdmin() ? 'Administrator' : 'Karyawan' }}</span></li>
                    <li><a class="dropdown-item" href="{{ route('profile.edit') }}"><i class="bi bi-gear"></i> Pengaturan</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger"><i class="bi bi-box-arrow-right"></i> Keluar</button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
        <div class="content">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('warning'))
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    {{ session('warning') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
@stack('scripts')
</body>
</html>
