<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - ToolsHub</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            min-height: 100vh;
            background-image:
                radial-gradient(circle at 15% 50%, rgba(112, 0, 255, 0.08), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(0, 242, 255, 0.08), transparent 25%);
            background-attachment: fixed;
        }

        .admin-container {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 260px;
            background: var(--bg-surface);
            border-right: 1px solid rgba(255, 255, 255, 0.08);
            padding: var(--spacing-lg) 0;
            display: flex;
            flex-direction: column;
            backdrop-filter: blur(10px);
        }

        .sidebar-header {
            padding: 0 var(--spacing-lg) var(--spacing-lg);
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: var(--spacing-md);
        }

        .sidebar-header h2 {
            color: var(--text-main);
            font-size: 1.5rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .sidebar-header h2 i {
            color: var(--neon-primary);
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: var(--spacing-xs);
            padding: 0 var(--spacing-md);
        }

        .nav-item {
            display: flex;
            align-items: center;
            padding: var(--spacing-sm) var(--spacing-md);
            color: var(--text-muted);
            text-decoration: none;
            transition: all 0.3s ease;
            border-radius: var(--radius-sm);
            font-weight: 500;
            border: 1px solid transparent;
        }

        .nav-item:hover,
        .nav-item.active {
            background: rgba(0, 242, 255, 0.1);
            color: var(--neon-primary);
            border-color: rgba(0, 242, 255, 0.2);
            box-shadow: 0 0 10px rgba(0, 242, 255, 0.1) inset;
        }

        .nav-item i {
            width: 24px;
            margin-right: var(--spacing-sm);
            text-align: center;
        }

        /* Main Content */
        .main-content {
            flex: 1;
            padding: var(--spacing-xl);
            overflow-y: auto;
        }

        .top-bar {
            background: var(--bg-surface);
            padding: var(--spacing-md) var(--spacing-xl);
            border-radius: var(--radius-md);
            margin-bottom: var(--spacing-xl);
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
        }

        .top-bar h1 {
            color: var(--text-main);
            font-size: 1.5rem;
            font-weight: 600;
            margin: 0;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: var(--spacing-md);
        }

        .logout-btn {
            background: transparent;
            color: var(--text-muted);
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: var(--spacing-xs) var(--spacing-md);
            border-radius: var(--radius-sm);
            cursor: pointer;
            font-size: 0.875rem;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logout-btn:hover {
            background: rgba(255, 0, 85, 0.1);
            color: var(--neon-accent);
            border-color: var(--neon-accent);
            box-shadow: 0 0 10px rgba(255, 0, 85, 0.2);
        }

        .content-card {
            background: var(--bg-surface);
            padding: var(--spacing-xl);
            border-radius: var(--radius-md);
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(10px);
        }

        /* Alerts */
        .alert {
            padding: var(--spacing-md);
            border-radius: var(--radius-sm);
            margin-bottom: var(--spacing-lg);
            animation: slideIn 0.3s ease;
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
        }

        .alert-success {
            background: rgba(0, 255, 157, 0.1);
            color: var(--neon-success);
            border: 1px solid rgba(0, 255, 157, 0.2);
        }

        .alert-error {
            background: rgba(255, 0, 85, 0.1);
            color: var(--neon-accent);
            border: 1px solid rgba(255, 0, 85, 0.2);
        }

        @keyframes slideIn {
            from {
                transform: translateY(-10px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        /* Form Styles Override */
        .form-group {
            margin-bottom: var(--spacing-lg);
        }

        .form-group label {
            display: block;
            margin-bottom: var(--spacing-xs);
            color: var(--text-muted);
            font-weight: 500;
        }

        .form-control {
            width: 100%;
            padding: var(--spacing-sm) var(--spacing-md);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            color: var(--text-main);
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--neon-primary);
            box-shadow: 0 0 10px rgba(0, 242, 255, 0.15);
            background: rgba(255, 255, 255, 0.05);
        }

        .btn-primary {
            background: var(--gradient-glow);
            color: var(--bg-deep);
            border: none;
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.4);
        }

        .btn-primary:hover {
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.6);
            transform: translateY(-2px);
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <h2><i class="fas fa-toolbox"></i> ToolsHub</h2>
                <p
                    style="color: var(--text-muted); font-size: 0.75rem; margin-top: var(--spacing-xs); margin-left: 2.5rem;">
                    Admin Panel</p>
            </div>
            <nav class="sidebar-nav">
                <a href="{{ route('admin.dashboard') }}"
                    class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('admin.settings.google-tags') }}"
                    class="nav-item {{ request()->routeIs('admin.settings.google-tags') ? 'active' : '' }}">
                    <i class="fas fa-tags"></i> Google Tags
                </a>
                <a href="{{ route('admin.settings.google-ads') }}"
                    class="nav-item {{ request()->routeIs('admin.settings.google-ads') ? 'active' : '' }}">
                    <i class="fas fa-bullhorn"></i> Google Ads
                </a>
                <a href="{{ route('home') }}" class="nav-item" target="_blank">
                    <i class="fas fa-globe"></i> View Site
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="main-content">
            <div class="top-bar">
                <h1>@yield('page-title', 'Dashboard')</h1>
                <div class="user-info">
                    <span style="color: var(--text-muted);">{{ Auth::guard('admin')->user()->email }}</span>
                    <form action="{{ route('admin.logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="logout-btn">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-error">
                    <ul style="margin-left: 20px;">
                        @foreach($errors->all() as $error)
                            <li><i class="fas fa-exclamation-circle"></i> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>

</html>