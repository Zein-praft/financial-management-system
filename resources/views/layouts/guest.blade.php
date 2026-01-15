<!DOCTYPE html>
<html lang="id" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Login' }} - FinTrack</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: { sans: ['"Plus Jakarta Sans"', 'sans-serif'] },
                    colors: { primary: '#6366F1', primaryDark: '#4338CA' }
                }
            }
        }
    </script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
        .auth-gradient { background: linear-gradient(135deg, #E0E7FF 0%, #F3F4F6 100%); }
        .dark .auth-gradient { background: linear-gradient(135deg, #0F172A 0%, #1E293B 100%); }
    </style>
    
    @livewireStyles
</head>
<body class="auth-gradient h-screen w-full flex items-center justify-center transition-colors duration-300">
    
    {{ $slot }}

    <!-- Script Dark Mode Logic -->
    <script>
        function initDarkMode() {
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        }
        function toggleDarkMode() {
            if (document.documentElement.classList.contains('dark')) {
                document.documentElement.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                document.documentElement.classList.add('dark');
                localStorage.theme = 'dark';
            }
        }
        document.addEventListener('DOMContentLoaded', () => { initDarkMode(); });
    </script>

    @livewireScripts
</body>
</html>