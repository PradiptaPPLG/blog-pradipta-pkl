<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-xl text-zinc-900 dark:text-zinc-100 leading-tight">
                    Dashboard Ringkasan CMS
                </h2>
                <p class="text-xs text-zinc-500 mt-1">
                    Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong>! Berikut aktivitas terkini blog Anda.
                </p>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.posts.create') }}" 
                   class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Tulis Artikel Baru
                </a>
            </div>
        </div>
    </x-slot>

    <!-- Stats Cards Grid -->
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-8">
        <!-- Card 1 -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <span class="text-xs font-semibold text-zinc-400">Total Artikel</span>
            <div class="mt-2 text-2xl font-extrabold text-zinc-900 dark:text-zinc-100">
                {{ $stats['total_posts'] }}
            </div>
            <span class="text-[11px] text-zinc-400">Semua status</span>
        </div>

        <!-- Card 2 -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <span class="text-xs font-semibold text-emerald-600 dark:text-emerald-400">Published</span>
            <div class="mt-2 text-2xl font-extrabold text-emerald-600 dark:text-emerald-400">
                {{ $stats['published_posts'] }}
            </div>
            <span class="text-[11px] text-zinc-400">Tayang di publik</span>
        </div>

        <!-- Card 3 -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <span class="text-xs font-semibold text-amber-600 dark:text-amber-400">Draft</span>
            <div class="mt-2 text-2xl font-extrabold text-amber-600 dark:text-amber-400">
                {{ $stats['draft_posts'] }}
            </div>
            <span class="text-[11px] text-zinc-400">Belum terbit</span>
        </div>

        <!-- Card 4 -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <span class="text-xs font-semibold text-indigo-600 dark:text-indigo-400">Total Views</span>
            <div class="mt-2 text-2xl font-extrabold text-indigo-600 dark:text-indigo-400">
                {{ number_format($stats['total_views']) }}
            </div>
            <span class="text-[11px] text-zinc-400">Akumulasi klik</span>
        </div>

        <!-- Card 5 -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <span class="text-xs font-semibold text-zinc-400">Kategori</span>
            <div class="mt-2 text-2xl font-extrabold text-zinc-900 dark:text-zinc-100">
                {{ $stats['total_categories'] }}
            </div>
            <span class="text-[11px] text-zinc-400">Topik artikel</span>
        </div>

        <!-- Card 6 -->
        <div class="p-5 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
            <span class="text-xs font-semibold text-zinc-400">Komentar</span>
            <div class="mt-2 text-2xl font-extrabold text-zinc-900 dark:text-zinc-100">
                {{ $stats['total_comments'] }}
            </div>
            <span class="text-[11px] text-zinc-400">Tanggapan pembaca</span>
        </div>
    </div>

    <!-- 2 Column Section: Recent Posts & Recent Comments -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Artikel Terbaru (8 cols) -->
        <div class="lg:col-span-8 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-sm text-zinc-900 dark:text-zinc-100">Artikel Terbaru</h3>
                <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                    Lihat Semua →
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="border-b border-zinc-100 dark:border-zinc-800 text-zinc-400 font-semibold uppercase tracking-wider text-[10px]">
                            <th class="pb-3">Judul Artikel</th>
                            <th class="pb-3">Kategori</th>
                            <th class="pb-3">Status</th>
                            <th class="pb-3">Views</th>
                            <th class="pb-3 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 font-medium">
                        @foreach ($recentPosts as $p)
                            <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/40 transition">
                                <td class="py-3 pr-4 max-w-xs truncate">
                                    <span class="font-semibold text-zinc-900 dark:text-zinc-100">{{ $p->title }}</span>
                                    <div class="text-[10px] text-zinc-400 mt-0.5">Oleh: {{ $p->user->name }}</div>
                                </td>
                                <td class="py-3">
                                    <span class="px-2 py-0.5 rounded text-[10px] bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                        {{ $p->category->name }}
                                    </span>
                                </td>
                                <td class="py-3">
                                    @if ($p->status === 'published')
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                            Published
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300">
                                            Draft
                                        </span>
                                    @endif
                                </td>
                                <td class="py-3 text-zinc-500 font-mono">
                                    {{ number_format($p->views_count) }}
                                </td>
                                <td class="py-3 text-right space-x-2">
                                    <a href="{{ route('admin.posts.edit', $p->id) }}" class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                        Edit
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Komentar Terkini (4 cols) -->
        <div class="lg:col-span-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <div class="flex items-center justify-between mb-5">
                <h3 class="font-bold text-sm text-zinc-900 dark:text-zinc-100">Komentar Masuk</h3>
                <a href="{{ route('admin.comments.index') }}" class="text-xs font-semibold text-indigo-600 dark:text-indigo-400 hover:underline">
                    Kelola →
                </a>
            </div>

            <div class="space-y-4">
                @foreach ($recentComments as $c)
                    <div class="p-3.5 rounded-xl border border-zinc-100 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/40 text-xs">
                        <div class="flex items-center justify-between mb-1.5">
                            <span class="font-bold text-zinc-800 dark:text-zinc-200">{{ $c->author_name }}</span>
                            <span class="text-[10px] text-zinc-400">{{ $c->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-zinc-600 dark:text-zinc-400 line-clamp-2 leading-relaxed">
                            "{{ $c->comment }}"
                        </p>
                        <div class="mt-2 text-[10px] text-zinc-400 truncate">
                            Pada: <span class="font-medium text-zinc-600 dark:text-zinc-300">{{ $c->post->title }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-app-layout>
