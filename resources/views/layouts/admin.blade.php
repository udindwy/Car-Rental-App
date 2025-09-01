<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CR | @isset($header)
            {{ $header }}@else{{ config('app.name', 'Laravel') }}
        @endisset
    </title>
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-50">
    <div x-data="{
        sidebarOpen: false,
        sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true'
    }" x-init="$watch('sidebarCollapsed', value => localStorage.setItem('sidebarCollapsed', value))">

        @include('layouts.partials.admin-sidebar')

        <div class="transition-all duration-300"
            :class="{ 'lg:ml-64': !sidebarCollapsed, 'lg:ml-0': sidebarCollapsed }">

            @include('layouts.partials.admin-navigation')

            <main class="p-4 sm:p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @stack('scripts')
</body>

</html>
