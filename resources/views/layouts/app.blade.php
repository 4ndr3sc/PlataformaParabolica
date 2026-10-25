<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AsoTV Guachetá')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="bg-gray-50">
    @if(Auth::check() && Auth::user()->isSuperuser())
        <nav class="sticky top-0 z-40 overflow-x-auto border-b border-slate-200 bg-white px-4 py-2 shadow-sm">
            @include('components.superuser-navigation', ['horizontalNavigation' => true])
        </nav>
    @elseif(Auth::check() && Auth::user()->isAdministrator())
        <nav class="sticky top-0 z-40 overflow-x-auto border-b border-slate-200 bg-white px-4 py-2 shadow-sm">
            @include('components.admin-navigation')
        </nav>
    @endif
    @yield('content')
    @include('components.public-chatbot')
</body>
</html>
