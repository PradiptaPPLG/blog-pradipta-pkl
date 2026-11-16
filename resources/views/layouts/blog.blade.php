<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'TechPulse - Publikasi Rekayasa Perangkat Lunak & Teknologi' }}</title>
    <meta name="description" content="Media catatan teknologi, tutorial Laravel, arsitektur database, dan pengalaman magang industri siswa SMK PPLG.">

    <!-- Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,600&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        body {
            font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
        }
        .prose pre {
            background-color: #0f172a;
            color: #e2e8f0;
            padding: 1.25rem;
            border-radius: 0.75rem;
            overflow-x: auto;
            font-size: 0.875rem;
            line-height: 1.6;
        }
        .prose code {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        }
    </style>
</head>
<body class="bg-zinc-50 dark:bg-zinc-950 text-zinc-900 dark:text-zinc-100 min-h-screen flex flex-col antialiased selection:bg-indigo-500 selection:text-white">

    <!-- Top Announcement Bar -->
    <div class="bg-zinc-900 text-zinc-300 text-xs py-2 px-4 border-b border-zinc-800">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="inline-flex items-center px-2 py-0.5 rounded text-[11px] font-semibold bg-indigo-500/20 text-indigo-300 border border-indigo-500/30">PKL Project</span>
                <span>Proyek Magang Hari Ke-1 • XI PPLG SMKN 1 Ciamis</span>
            </div>
            <div class="hidden sm:flex items-center gap-4 text-zinc-400">
                <span>Ditenagai Laravel 12 & Tailwind</span>
            </div>
        </div>
    </div>

    <!-- Main Navigation Header -->
    <header class="sticky top-0 z-40 bg-white/80 dark:bg-zinc-950/80 backdrop-blur-md border-b border-zinc-200 dark:border-zinc-800 transition-colors">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 h-16 flex items-center justify-between">
            <!-- Brand Logo -->
            <a href="{{ route('blog.index') }}" class="group flex items-center gap-2.5">
                <img src="{{ asset('images/logo_techpulse.jpg') }}" alt="TechPulse Logo" 
                     class="w-10 h-10 rounded-xl object-cover border border-zinc-200 dark:border-zinc-800 shadow-sm group-hover:scale-105 transition-transform">
                <div class="flex flex-col">
                    <span class="font-extrabold text-xl tracking-tight text-zinc-900 dark:text-white leading-none">
                        TechPulse<span class="text-cyan-500">.</span>
                    </span>
                    <span class="text-[10px] uppercase font-semibold text-zinc-400 tracking-wider">Engineering Blog</span>
                </div>
            </a>

            <!-- Search Bar in Header -->
            <form action="{{ route('blog.index') }}" method="GET" class="hidden md:flex items-center relative w-72">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel, topik..." 
                    class="w-full text-xs rounded-full bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 px-3.5 py-2 pl-9 text-zinc-800 dark:text-zinc-200 placeholder-zinc-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition">
                <svg class="w-4 h-4 text-zinc-400 absolute left-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </form>

            <!-- Navigation Links & Auth -->
            <div class="flex items-center gap-3">
                <a href="{{ route('blog.index') }}" class="text-xs font-semibold text-zinc-600 dark:text-zinc-300 hover:text-indigo-600 dark:hover:text-white transition px-2 py-1">
                    Semua Artikel
                </a>

                @auth
                    <a href="{{ route('admin.dashboard') }}" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-lg text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                        Dashboard CMS
                    </a>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-zinc-700 dark:text-zinc-300 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                        Masuk Penulis
                    </a>
                @endauth
            </div>
        </div>
    </header>

    <!-- Global Toast / Alert -->
    <div class="max-w-6xl mx-auto px-4 sm:px-6 w-full pt-4">
        @if (session('success'))
            <div class="mb-4 rounded-xl border border-emerald-200 dark:border-emerald-800 bg-emerald-50 dark:bg-emerald-950/60 p-4 text-sm text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-sm">
                <div class="flex items-center gap-2.5">
                    <svg class="w-5 h-5 text-emerald-600 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                    <span>{{ session('success') }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Main Content Container -->
    <main class="flex-1">
        {{ $slot }}
    </main>

    <!-- Professional Footer -->
    <footer class="mt-20 border-t border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-950 py-12">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                <!-- Col 1: Brand -->
                <div class="md:col-span-2">
                    <div class="flex items-center gap-2.5 mb-3">
                        <img src="{{ asset('images/logo_techpulse.jpg') }}" alt="TechPulse Logo" 
                             class="w-8 h-8 rounded-lg object-cover border border-zinc-200 dark:border-zinc-800 shadow-sm">
                        <span class="font-extrabold text-lg tracking-tight">TechPulse<span class="text-cyan-500">.</span></span>
                    </div>
                    <p class="text-xs text-zinc-500 leading-relaxed max-w-md">
                        Blog publikasi teknis yang didedikasikan untuk berbagi pengetahuan tentang rekayasa perangkat lunak, eksplorasi framework Laravel, arsitektur basis data, dan dokumentasi tugas magang industri.
                    </p>
                </div>

                <!-- Col 2: Kategori Cepat -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-3">Topik Utama</h4>
                    <ul class="space-y-2 text-xs text-zinc-600 dark:text-zinc-400">
                        <li><a href="{{ route('blog.index', ['category' => 'web-development']) }}" class="hover:text-indigo-600 transition">Web Development</a></li>
                        <li><a href="{{ route('blog.index', ['category' => 'backend-database']) }}" class="hover:text-indigo-600 transition">Backend & Database</a></li>
                        <li><a href="{{ route('blog.index', ['category' => 'karier-tips-pkl']) }}" class="hover:text-indigo-600 transition">Karier & Tips PKL</a></li>
                        <li><a href="{{ route('blog.index', ['category' => 'ui-ux-frontend']) }}" class="hover:text-indigo-600 transition">UI/UX & Frontend</a></li>
                    </ul>
                </div>

                <!-- Col 3: Pengembang & Sekolah -->
                <div>
                    <h4 class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-3">Informasi Magang</h4>
                    <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed">
                        <strong>Developer:</strong> Pradipta Endra Maulana<br>
                        <strong>Kelas:</strong> XI PPLG<br>
                        <strong>Instansi:</strong> SMKN 1 Ciamis<br>
                        <strong>Tugas:</strong> Project Blog Hari ke-1
                    </p>
                </div>
            </div>

            <div class="pt-8 border-t border-zinc-100 dark:border-zinc-800 flex flex-col sm:flex-row items-center justify-between text-xs text-zinc-400 gap-4">
                <p>&copy; {{ date('Y') }} TechPulse Blog. Dikembangkan dengan sepenuh hati dan kode bersih.</p>
                <div class="flex items-center gap-4">
                    <span class="inline-flex items-center gap-1.5 text-zinc-500">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Semua sistem beroperasi normal
                    </span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>
