<x-blog-layout>
    <x-slot:title>
        {{ $currentCategory ? $currentCategory->name . ' - TechPulse Blog' : 'TechPulse - Publikasi Rekayasa Perangkat Lunak' }}
    </x-slot:title>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-8 md:py-12">
        
        <!-- Hero Section -->
        <div class="mb-10 text-center md:text-left border-b border-zinc-200 dark:border-zinc-800 pb-10">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/60 text-indigo-700 dark:text-indigo-400 border border-indigo-200 dark:border-indigo-800/50 mb-4">
                <span>Catatan & Riset Teknologi</span>
            </div>
            <h1 class="text-3xl sm:text-4xl md:text-5xl font-extrabold tracking-tight text-zinc-900 dark:text-zinc-50 leading-tight">
                Menulis Kode yang Lebih Bersih, Membangun Sistem yang Lebih Tangguh.
            </h1>
            <p class="mt-4 text-base sm:text-lg text-zinc-600 dark:text-zinc-400 max-w-3xl leading-relaxed">
                Jurnal teknis yang mendokumentasikan eksplorasi framework Laravel, arsitektur database relasional, best practices clean code, dan adaptasi di industri perangkat lunak.
            </p>
        </div>

        <!-- Filter Kategori & Search Bar -->
        <div class="mb-10 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <!-- Category Pills -->
            <div class="flex items-center gap-2 overflow-x-auto pb-2 scrollbar-none">
                <a href="{{ route('blog.index') }}" 
                   class="whitespace-nowrap px-3.5 py-1.5 rounded-full text-xs font-medium transition {{ !request('category') && !request('tag') ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 shadow-sm' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800' }}">
                    Semua Topik
                </a>
                @foreach ($categories as $cat)
                    <a href="{{ route('blog.index', ['category' => $cat->slug]) }}" 
                       class="whitespace-nowrap px-3.5 py-1.5 rounded-full text-xs font-medium transition flex items-center gap-1.5 {{ request('category') === $cat->slug ? 'bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 shadow-sm' : 'bg-zinc-100 text-zinc-600 hover:bg-zinc-200 dark:bg-zinc-900 dark:text-zinc-400 dark:hover:bg-zinc-800' }}">
                        <span>{{ $cat->name }}</span>
                        <span class="text-[10px] opacity-75 font-mono">({{ $cat->published_posts_count }})</span>
                    </a>
                @endforeach
            </div>

            <!-- Search Form on Mobile / Secondary -->
            <form action="{{ route('blog.index') }}" method="GET" class="md:hidden flex items-center relative w-full">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari artikel..." 
                    class="w-full text-xs rounded-xl bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 px-3.5 py-2.5 pl-9 text-zinc-800 dark:text-zinc-200 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 text-zinc-400 absolute left-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </form>
        </div>

        <!-- Active Filter Indicator -->
        @if (request('search') || request('category') || request('tag'))
            <div class="mb-6 p-4 rounded-xl bg-zinc-100 dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 flex items-center justify-between text-xs">
                <div class="flex items-center gap-2">
                    <span class="text-zinc-500">Menampilkan hasil untuk:</span>
                    @if (request('search'))
                        <span class="font-semibold text-zinc-900 dark:text-zinc-100">"{{ request('search') }}"</span>
                    @endif
                    @if ($currentCategory)
                        <span class="px-2 py-0.5 rounded bg-zinc-200 dark:bg-zinc-800 font-semibold">{{ $currentCategory->name }}</span>
                    @endif
                    @if ($currentTag)
                        <span class="px-2 py-0.5 rounded bg-indigo-100 text-indigo-700 dark:bg-indigo-950 dark:text-indigo-300 font-semibold">#{{ $currentTag->name }}</span>
                    @endif
                </div>
                <a href="{{ route('blog.index') }}" class="text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                    Reset Filter
                </a>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10">
            
            <!-- Main Content: Articles List (8 cols) -->
            <div class="lg:col-span-8 space-y-8">
                @if ($posts->count() > 0)
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                        @foreach ($posts as $post)
                            <article class="group flex flex-col justify-between rounded-2xl border border-zinc-200/80 dark:border-zinc-800 bg-white dark:bg-zinc-900 overflow-hidden hover:border-zinc-300 dark:hover:border-zinc-700 hover:shadow-lg hover:shadow-zinc-500/5 transition duration-300">
                                <div>
                                    <!-- Image Thumbnail -->
                                    <a href="{{ route('blog.show', $post->slug) }}" class="block relative aspect-video overflow-hidden bg-zinc-100 dark:bg-zinc-800">
                                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-500">
                                        <div class="absolute top-3 left-3">
                                            <span class="px-2.5 py-1 rounded-full text-[11px] font-semibold bg-white/90 dark:bg-zinc-950/90 text-zinc-800 dark:text-zinc-200 backdrop-blur-sm shadow-sm">
                                                {{ $post->category->name }}
                                            </span>
                                        </div>
                                    </a>

                                    <!-- Content -->
                                    <div class="p-5">
                                        <div class="flex items-center gap-2 text-[11px] text-zinc-400 mb-2.5 font-medium">
                                            <time datetime="{{ $post->published_at?->toIso8601String() }}">
                                                {{ $post->published_at?->translatedFormat('d M Y') ?? $post->created_at->format('d M Y') }}
                                            </time>
                                            <span>•</span>
                                            <span>{{ $post->reading_time }} mnt baca</span>
                                        </div>

                                        <h2 class="text-lg font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition leading-snug line-clamp-2">
                                            <a href="{{ route('blog.show', $post->slug) }}">
                                                {{ $post->title }}
                                            </a>
                                        </h2>

                                        <p class="mt-2.5 text-xs text-zinc-500 dark:text-zinc-400 line-clamp-3 leading-relaxed">
                                            {{ Str::limit(strip_tags($post->body), 140) }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Card Footer -->
                                <div class="px-5 pb-5 pt-0 mt-auto flex items-center justify-between border-t border-zinc-100 dark:border-zinc-800/60 pt-3">
                                    <div class="flex items-center gap-2">
                                        <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" 
                                             class="w-6 h-6 rounded-full object-cover object-top border border-zinc-200 dark:border-zinc-700">
                                        <span class="text-xs font-medium text-zinc-600 dark:text-zinc-300">{{ $post->user->name }}</span>
                                    </div>

                                    <div class="flex items-center gap-1 text-[11px] text-zinc-400">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        <span>{{ number_format($post->views_count) }}</span>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination -->
                    <div class="pt-6">
                        {{ $posts->links() }}
                    </div>
                @else
                    <div class="p-12 text-center rounded-2xl border border-dashed border-zinc-300 dark:border-zinc-800 bg-white dark:bg-zinc-900">
                        <svg class="mx-auto h-12 w-12 text-zinc-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                        </svg>
                        <h3 class="text-base font-bold text-zinc-800 dark:text-zinc-200">Tidak ada artikel ditemukan</h3>
                        <p class="mt-1 text-xs text-zinc-500">Coba gunakan kata kunci pencarian lain atau pilih kategori yang berbeda.</p>
                        <div class="mt-4">
                            <a href="{{ route('blog.index') }}" class="inline-flex items-center px-4 py-2 rounded-lg text-xs font-medium text-white bg-indigo-600 hover:bg-indigo-700 transition">
                                Lihat Semua Artikel
                            </a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar (4 cols) -->
            <aside class="lg:col-span-4 space-y-8">
                
                <!-- Box Penulis PKL -->
                <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm">
                    <div class="flex items-center gap-3.5 mb-4">
                        <img src="{{ asset('images/ProfilePortifolioProfessional.jpg') }}" alt="Pradipta Endra Maulana" 
                             class="w-14 h-14 rounded-2xl object-cover object-top border-2 border-indigo-500 shadow-md">
                        <div>
                            <h3 class="font-bold text-sm text-zinc-900 dark:text-zinc-100">Pradipta Endra Maulana</h3>
                            <p class="text-xs text-zinc-500">Siswa XI PPLG • SMKN 1 Ciamis</p>
                        </div>
                    </div>
                    <p class="text-xs text-zinc-600 dark:text-zinc-400 leading-relaxed mb-4">
                        Sedang melaksanakan Praktik Kerja Lapangan (PKL). Project blog ini dirancang dengan pendekatan modular, clean architecture di Laravel, dan relasi database yang terstruktur.
                    </p>
                    <div class="pt-3 border-t border-zinc-100 dark:border-zinc-800 flex items-center justify-between text-xs">
                        <span class="text-zinc-400">Status Magang</span>
                        <span class="font-semibold text-emerald-600 dark:text-emerald-400 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span> Aktif Hari Ke-1
                        </span>
                    </div>
                </div>

                <!-- Artikel Populer -->
                <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M12.395 2.553a1 1 0 00-1.45-.385c-.345.23-.614.558-.822.88-.316.492-.474.966-.567 1.343-.223.906-.32 1.637-.32 1.637s-.462-.51-.954-.93a4.01 4.01 0 00-2.483-.902c-.893 0-1.748.337-2.392.946-.644.609-.99 1.442-.99 2.317 0 .584.148 1.157.428 1.666.28.51.682.936 1.168 1.238.15.093.308.174.472.242a5.52 5.52 0 00-.236.852c-.114.624-.047 1.25.195 1.83.242.58.647 1.077 1.165 1.433.518.356 1.127.545 1.753.545.498 0 .99-.12 1.432-.351.443-.23.823-.563 1.107-.971.284-.407.464-.88.525-1.378.061-.497.009-1-.153-1.464-.162-.464-.436-.88-.798-1.21-.362-.33-.807-.57-1.293-.7-.487-.13-.996-.145-1.488-.044z"/></svg>
                        Artikel Terpopuler
                    </h3>

                    <div class="space-y-4">
                        @foreach ($popularPosts as $pop)
                            <a href="{{ route('blog.show', $pop->slug) }}" class="group block">
                                <div class="flex items-start gap-3">
                                    <span class="w-6 h-6 rounded-md bg-zinc-100 dark:bg-zinc-800 text-zinc-500 font-mono text-xs font-bold flex items-center justify-center shrink-0 group-hover:bg-indigo-600 group-hover:text-white transition">
                                        {{ $loop->iteration }}
                                    </span>
                                    <div>
                                        <h4 class="text-xs font-semibold text-zinc-800 dark:text-zinc-200 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition leading-snug">
                                            {{ $pop->title }}
                                        </h4>
                                        <div class="mt-1 flex items-center gap-2 text-[10px] text-zinc-400">
                                            <span>{{ $pop->category->name }}</span>
                                            <span>•</span>
                                            <span>{{ number_format($pop->views_count) }} views</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <!-- Box Teknologi yang Dipakai -->
                <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm">
                    <h3 class="text-xs font-bold uppercase tracking-wider text-zinc-400 mb-3">Arsitektur & Tech Stack</h3>
                    <div class="flex flex-wrap gap-1.5">
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">Laravel 12 (MVC)</span>
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">MySQL Database</span>
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">Eloquent ORM</span>
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">Tailwind CSS</span>
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">Blade Component</span>
                        <span class="px-2.5 py-1 rounded-md text-[11px] font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">Laravel Breeze</span>
                    </div>
                </div>

            </aside>
        </div>
    </div>
</x-blog-layout>
