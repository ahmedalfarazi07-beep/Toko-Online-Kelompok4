<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'Toko Online' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;500;600;700;800&family=DM+Sans:wght@400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')

    {{-- Apply theme BEFORE render to prevent flash --}}
    <script>
        (function() {
            var saved = localStorage.getItem('theme');
            if (!saved) {
                saved = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            }
            if (saved === 'light') {
                document.documentElement.classList.add('light');
            }
        })();
    </script>
</head>
<body class="font-sans antialiased min-h-screen flex items-center justify-center relative overflow-hidden"
      style="background-color: var(--bg-primary); color: var(--text-primary);">

    @if(isset($fullBg) && $fullBg)
        <div class="absolute inset-0 z-0">
            <img src="https://images.unsplash.com/photo-1531366936337-7c912a4589a7?w=1920&q=80" alt="Background" class="w-full h-full object-cover">
            <div class="absolute inset-0 bg-gradient-to-b from-black/40 via-black/20 to-black/60"></div>
        </div>
    @else
        <div class="absolute inset-0 bg-gradient-to-br from-accent/10 via-transparent to-accent/5 pointer-events-none"></div>
        <div class="absolute top-0 left-0 w-96 h-96 bg-accent/10 rounded-full blur-3xl"></div>
        <div class="absolute bottom-0 right-0 w-96 h-96 bg-highlight/10 rounded-full blur-3xl"></div>
    @endif

    <div class="relative z-10 w-full px-4">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
