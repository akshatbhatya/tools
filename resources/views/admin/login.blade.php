<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - ToolsHub</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background-color: var(--bg-deep);
            color: var(--text-main);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: var(--spacing-md);
            background-image:
                radial-gradient(circle at 15% 50%, rgba(112, 0, 255, 0.08), transparent 25%),
                radial-gradient(circle at 85% 30%, rgba(0, 242, 255, 0.08), transparent 25%);
            background-attachment: fixed;
        }

        .login-container {
            background: var(--bg-surface);
            padding: var(--spacing-2xl);
            border-radius: var(--radius-lg);
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
            width: 100%;
            max-width: 450px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            backdrop-filter: blur(12px);
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                transform: translateY(20px);
                opacity: 0;
            }

            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .login-header {
            text-align: center;
            margin-bottom: var(--spacing-xl);
        }

        .login-header h1 {
            color: var(--text-main);
            font-size: 1.75rem;
            font-weight: 700;
            margin-bottom: var(--spacing-xs);
        }

        .login-header p {
            color: var(--text-muted);
            font-size: 0.875rem;
        }

        .logo {
            font-size: 3rem;
            margin-bottom: var(--spacing-md);
            color: var(--neon-primary);
            display: inline-block;
            filter: drop-shadow(0 0 10px rgba(0, 242, 255, 0.3));
        }

        .form-group {
            margin-bottom: var(--spacing-lg);
        }

        .form-group label {
            display: block;
            margin-bottom: var(--spacing-xs);
            color: var(--text-muted);
            font-weight: 500;
            font-size: 0.875rem;
        }

        .form-control {
            width: 100%;
            padding: var(--spacing-md);
            background: rgba(255, 255, 255, 0.03);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: var(--radius-sm);
            color: var(--text-main);
            font-size: 1rem;
            transition: all 0.2s;
        }

        .form-control:focus {
            outline: none;
            border-color: var(--neon-primary);
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.15);
            background: rgba(255, 255, 255, 0.05);
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: var(--spacing-sm);
            margin-bottom: var(--spacing-lg);
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: var(--neon-primary);
        }

        .remember-me label {
            color: var(--text-muted);
            font-size: 0.875rem;
            cursor: pointer;
        }

        .btn-login {
            width: 100%;
            padding: var(--spacing-md);
            background: var(--gradient-glow);
            color: var(--bg-deep);
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            box-shadow: 0 0 15px rgba(0, 242, 255, 0.4);
        }

        .btn-login:hover {
            opacity: 0.9;
            transform: translateY(-1px);
            box-shadow: 0 0 30px rgba(0, 242, 255, 0.6);
        }

        .alert {
            padding: var(--spacing-md);
            border-radius: var(--radius-sm);
            margin-bottom: var(--spacing-lg);
            font-size: 0.875rem;
        }

        .alert-error {
            background: rgba(255, 0, 85, 0.1);
            color: var(--neon-accent);
            border: 1px solid rgba(255, 0, 85, 0.2);
        }

        .back-to-site {
            text-align: center;
            margin-top: var(--spacing-lg);
        }

        .back-to-site a {
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.875rem;
            transition: color 0.2s;
            display: inline-flex;
            align-items: center;
            gap: var(--spacing-xs);
        }

        .back-to-site a:hover {
            color: var(--neon-primary);
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-header">
            <div class="logo">
                <i class="fas fa-toolbox"></i>
            </div>
            <h1>Admin Login</h1>
            <p>ToolsHub Administration Panel</p>
        </div>

        @if($errors->any())
            <div class="alert alert-error">
                @foreach($errors->all() as $error)
                    <div style="display: flex; align-items: center; gap: 8px;">
                        <i class="fas fa-exclamation-circle"></i> {{ $error }}
                    </div>
                @endforeach
            </div>
        @endif

        <form action="{{ route('admin.login') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" required
                    autofocus placeholder="admin@toolapp.com">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" class="form-control" required
                    placeholder="Enter your password">
            </div>

            <div class="remember-me">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember">Remember me</label>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Sign In
            </button>
        </form>

        <div class="back-to-site">
            <a href="{{ route('home') }}">
                <i class="fas fa-arrow-left"></i> Back to Website
            </a>
        </div>
    </div>
</body>

</html>