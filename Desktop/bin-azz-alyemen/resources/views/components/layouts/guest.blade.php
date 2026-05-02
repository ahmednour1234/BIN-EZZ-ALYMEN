<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'تسجيل الدخول - بن عز اليمن' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@300;400;500;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Tajawal', 'ui-sans-serif', 'system-ui', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50:  '#F7F4F1',
                            100: '#F0E8DF',
                            200: '#E6C58A',
                            300: '#C9A66B',
                            400: '#B8916A',
                            500: '#8D6E63',
                            600: '#8D6E63',
                            700: '#6D4C41',
                            800: '#4E342E',
                            900: '#3E2723',
                        },
                        surface: '#F7F4F1',
                        'surface-dark': '#EDE5DB',
                        card: '#ffffff',
                        sidebar: '#6D4C41',
                        'sidebar-hover': '#4E342E',
                        'sidebar-active': '#3E2723',
                    },
                },
            },
        }
    </script>
    @livewireStyles
</head>
<body class="font-sans antialiased bg-surface text-gray-800">
    <div class="min-h-screen flex items-center justify-center p-4">
        {{ $slot }}
    </div>
    @livewireScripts
</body>
</html>
