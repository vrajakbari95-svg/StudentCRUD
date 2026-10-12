<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#f8faff">
    <title>@yield('title', 'Student Management')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>
    <div class="app-shell">
        <header class="topbar">
            <a class="brand" href="{{ route('students.index') }}" aria-label="Student Management home">
                <span class="brand-mark" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none">
                        <path d="M3.5 9.1 12 4l8.5 5.1L12 14.2 3.5 9.1Z" stroke="currentColor" stroke-width="1.8" stroke-linejoin="round"/>
                        <path d="M7 11.3v4.1c0 1.2 2.2 2.7 5 2.7s5-1.5 5-2.7v-4.1M20.5 9.2v5" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
                <span class="brand-name">Student<span>Management</span>System</span>
            </a>
            <div class="topbar-note">
                <span class="status-dot"></span>
                Student workspace
            </div>
        </header>

        <main class="page-content">
            @yield('content')
        </main>
    </div>
    @include('partials.alerts')
</body>
</html>
