<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'نظام إدارة العقارات')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Tailwind CSS --}}
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans leading-normal tracking-normal">

    {{-- Navbar --}}
    <nav class="bg-gradient-to-r from-blue-700 to-blue-900 shadow-lg sticky top-0 z-50">
        <div class="container mx-auto px-6">
            <div class="flex justify-between items-center py-4">

                {{-- Logo --}}
                <a href="{{ url('/') }}" class="text-2xl font-extrabold text-white hover:text-red-300 transition transform hover:scale-105">
                    🏠 الفريدة
                </a>

                {{-- Links Desktop --}}
                <div class="hidden md:flex items-center gap-8 text-white font-medium">

                    {{-- إدارة العمليات --}}
                    <div class="flex items-center gap-4">
                        <span class="text-red-300 font-semibold">الإدارة</span>
                        <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">المبيعات</a>
                        <a href="{{ route('revenues.index') }}" class="nav-link {{ request()->routeIs('revenues.*') ? 'active' : '' }}">الإيرادات</a>
                        <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">المصروفات</a>
                        <a href="{{ route('cashbox.index') }}" class="nav-link {{ request()->routeIs('cashbox.*') ? 'active' : '' }}">الخزنة</a>
                        <a href="{{ route('advances.index') }}" class="nav-link {{ request()->routeIs('advances.*') ? 'active' : '' }}">العهدة</a>
                    
                    </div>

                    {{-- Divider --}}
                    <div class="w-px h-6 bg-white/40"></div>

                    {{-- البيانات الأساسية --}}
                    <div class="flex items-center gap-4">
                        <span class="text-red-300 font-semibold">البيانات</span>
                        <a href="{{ route('units.index') }}" class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}">الوحدات</a>
                        <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">العملاء</a>
                        <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">لوحة التحكم</a>
                    </div>
                </div>

                {{-- Mobile Menu Button --}}
                <div class="md:hidden">
                    <button id="menu-btn" class="text-white text-2xl focus:outline-none">☰</button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div id="mobile-menu" class="hidden flex-col space-y-2 pb-4 md:hidden text-white font-medium transition-all duration-500">
                <p class="text-red-300 mt-2">الإدارة</p>
                <a href="{{ route('sales.index') }}" class="nav-link {{ request()->routeIs('sales.*') ? 'active' : '' }}">المبيعات</a>
                <a href="{{ route('revenues.index') }}" class="nav-link {{ request()->routeIs('revenues.*') ? 'active' : '' }}">الإيرادات</a>
                <a href="{{ route('expenses.index') }}" class="nav-link {{ request()->routeIs('expenses.*') ? 'active' : '' }}">المصروفات</a>
                <a href="{{ route('cashbox.index') }}" class="nav-link {{ request()->routeIs('cashbox.*') ? 'active' : '' }}">الخزنة</a>
                <a href="#" class="nav-link">العهدة</a>

                <p class="text-red-300 mt-4">البيانات</p>
                <a href="{{ route('units.index') }}" class="nav-link {{ request()->routeIs('units.*') ? 'active' : '' }}">الوحدات</a>
                <a href="{{ route('clients.index') }}" class="nav-link {{ request()->routeIs('clients.*') ? 'active' : '' }}">العملاء</a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main class="container mx-auto mt-8 px-4">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-blue-700 text-white text-center p-4 mt-12 shadow-inner">
        <p class="font-semibold">جميع الحقوق محفوظة © {{ date('Y') }} - نظام الفريدة</p>
    </footer>

    {{-- Styles --}}
    <style>
        .nav-link {
            padding: 6px 12px;
            border-radius: 9999px; /* pill style */
            transition: all 0.3s ease;
        }
        .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.2);
            color: #fca5a5; /* Red-300 */
            transform: scale(1.05);
        }
        .nav-link.active {
            background-color: #ef4444; /* Red-500 */
            color: white !important;
            font-weight: bold;
        }
    </style>

    {{-- Mobile Menu Toggle --}}
    <script>
        const menuBtn = document.getElementById('menu-btn');
        const mobileMenu = document.getElementById('mobile-menu');
        menuBtn.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>
