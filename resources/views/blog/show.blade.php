<x-blog-layout>
    <x-slot:title>
        {{ $post->title }} - TechPulse Blog
    </x-slot:title>
    <x-slot:metaDescription>
        {{ $post->excerpt }}
    </x-slot:metaDescription>
    <x-slot:ogImage>
        {{ $post->thumbnail_url }}
    </x-slot:ogImage>

    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 md:py-12">
        
        <!-- Breadcrumbs -->
        <nav class="flex items-center gap-2 text-xs text-zinc-400 mb-6 font-medium">
            <a href="{{ route('blog.index') }}" class="hover:text-zinc-600 dark:hover:text-zinc-200 transition">Beranda</a>
            <span>/</span>
            <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" class="hover:text-zinc-600 dark:hover:text-zinc-200 transition">
                {{ $post->category->name }}
            </a>
            <span>/</span>
            <span class="text-zinc-600 dark:text-zinc-300 truncate max-w-xs">{{ $post->title }}</span>
        </nav>

        <!-- Article Header -->
        <header class="mb-8">
            <div class="flex items-center gap-3 mb-4">
                <a href="{{ route('blog.index', ['category' => $post->category->slug]) }}" 
                   class="px-3 py-1 rounded-full text-xs font-semibold bg-indigo-50 dark:bg-indigo-950/80 text-indigo-700 dark:text-indigo-300 border border-indigo-200 dark:border-indigo-800">
                    {{ $post->category->name }}
                </a>
                <span class="text-xs text-zinc-400">•</span>
                <span class="text-xs text-zinc-500 font-medium">{{ $post->reading_time }} menit membaca</span>
                <span class="text-xs text-zinc-400">•</span>
                <span class="text-xs text-zinc-500 font-medium flex items-center gap-1">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                    {{ number_format($post->views_count) }} views
                </span>
            </div>

            <h1 class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-extrabold text-zinc-900 dark:text-zinc-50 tracking-tight leading-tight">
                {{ $post->title }}
            </h1>

            <!-- Author & Metadata Bar -->
            <div class="mt-6 pt-6 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" 
                         class="w-11 h-11 rounded-full object-cover object-top border-2 border-indigo-500 shadow-sm">
                    <div>
                        <div class="font-bold text-sm text-zinc-900 dark:text-zinc-100 flex items-center gap-2">
                            <span>{{ $post->user->name }}</span>
                            <span class="text-[10px] uppercase tracking-wider font-semibold px-2 py-0.5 rounded bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                {{ $post->user->role }}
                            </span>
                        </div>
                        <time datetime="{{ $post->published_at?->toIso8601String() }}" class="text-xs text-zinc-400">
                            Diterbitkan pada {{ $post->published_at?->translatedFormat('d F Y') ?? $post->created_at->format('d F Y') }}
                        </time>
                    </div>
                </div>

                <div class="flex items-center gap-2">
                    <a href="{{ route('blog.index') }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold text-zinc-600 dark:text-zinc-300 bg-zinc-100 dark:bg-zinc-800 hover:bg-zinc-200 dark:hover:bg-zinc-700 transition">
                        ← Kembali
                    </a>
                </div>
            </div>
        </header>

        <!-- Featured Thumbnail Image -->
        @if ($post->thumbnail)
            <div class="mb-10 rounded-2xl overflow-hidden shadow-lg border border-zinc-200 dark:border-zinc-800 bg-zinc-100 dark:bg-zinc-900 aspect-video max-h-[460px]">
                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
            </div>
        @endif

        <!-- Article Content Body -->
        <article class="prose prose-zinc dark:prose-invert max-w-none prose-headings:font-bold prose-headings:tracking-tight prose-headings:text-zinc-900 dark:prose-headings:text-zinc-100 prose-a:text-indigo-600 hover:prose-a:underline prose-img:rounded-xl text-zinc-700 dark:text-zinc-300 leading-relaxed text-base sm:text-lg mb-12">
            {!! Str::markdown($post->body) !!}
        </article>

        <!-- Tags List -->
        @if ($post->tags->count() > 0)
            <div class="pt-6 pb-8 border-t border-zinc-200 dark:border-zinc-800 flex items-center gap-2 flex-wrap">
                <span class="text-xs font-semibold text-zinc-400">Topik Terkait:</span>
                @foreach ($post->tags as $tag)
                    <a href="{{ route('blog.index', ['tag' => $tag->slug]) }}" 
                       class="px-3 py-1 rounded-lg text-xs font-medium bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 hover:bg-indigo-50 hover:text-indigo-600 dark:hover:bg-indigo-950 dark:hover:text-indigo-300 transition">
                        #{{ $tag->name }}
                    </a>
                @endforeach
            </div>
        @endif

        <!-- Author Profile Box -->
        <div class="my-10 p-6 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-zinc-100/70 dark:bg-zinc-900/60 flex items-start gap-4">
            <img src="{{ $post->user->avatar_url }}" alt="{{ $post->user->name }}" 
                 class="w-14 h-14 rounded-full object-cover object-top border-2 border-indigo-500 shrink-0 shadow-md">
            <div>
                <h3 class="font-bold text-sm text-zinc-900 dark:text-zinc-100">Ditulis oleh {{ $post->user->name }}</h3>
                <p class="mt-1 text-xs text-zinc-500 leading-relaxed">
                    {{ $post->user->role === 'admin' ? 'Pengembang utama platform TechPulse. Siswa XI PPLG SMKN 1 Ciamis yang mendokumentasikan eksplorasi arsitektur sistem dan pengalaman magang industri.' : 'Kontributor teknis di TechPulse. Menulis artikel seputar praktik pengembangan web dan arsitektur backend.' }}
                </p>
            </div>
        </div>

        <!-- Comments Section -->
        <section class="mt-14 pt-10 border-t border-zinc-200 dark:border-zinc-800">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-xl font-extrabold tracking-tight text-zinc-900 dark:text-zinc-100">
                    Diskusi & Komentar ({{ $post->approvedComments->count() }})
                </h2>
                <span class="text-xs text-zinc-400 font-medium">Bebas & Terbuka</span>
            </div>

            <!-- List Existing Comments -->
            <div class="space-y-4 mb-10">
                @forelse ($post->approvedComments as $comment)
                    <div class="p-5 rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 shadow-sm">
                        <div class="flex items-center justify-between mb-2">
                            <div class="flex items-center gap-2.5">
                                @if ($comment->user && $comment->user->avatar_url)
                                    <img src="{{ $comment->user->avatar_url }}" alt="{{ $comment->author_name }}" 
                                         class="w-7 h-7 rounded-full object-cover object-top border border-indigo-500/40 shrink-0">
                                @else
                                    <span class="w-7 h-7 rounded-full bg-indigo-100 dark:bg-indigo-950 text-indigo-700 dark:text-indigo-300 font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                                    </span>
                                @endif
                                <span class="font-bold text-xs text-zinc-900 dark:text-zinc-100">
                                    {{ $comment->author_name }}
                                </span>
                                @if ($comment->user_id)
                                    <span class="px-2 py-0.5 rounded text-[10px] font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-600 dark:text-zinc-400">
                                        Member
                                    </span>
                                @endif
                            </div>
                            <time class="text-[11px] text-zinc-400">
                                {{ $comment->created_at->diffForHumans() }}
                            </time>
                        </div>
                        <p class="text-xs sm:text-sm text-zinc-600 dark:text-zinc-300 leading-relaxed pl-9">
                            {{ $comment->comment }}
                        </p>
                    </div>
                @empty
                    <div class="p-8 text-center rounded-2xl border border-dashed border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-900/40">
                        <p class="text-xs text-zinc-500">Belum ada komentar pada artikel ini. Jadilah yang pertama memberikan tanggapan!</p>
                    </div>
                @endforelse
            </div>

            <!-- Add Comment Form -->
            <div class="rounded-2xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 p-6 shadow-sm">
                <h3 class="text-sm font-bold text-zinc-900 dark:text-zinc-100 mb-4">
                    Tinggalkan Komentar Anda
                </h3>

                <form action="{{ route('comments.store', $post->id) }}" method="POST" class="space-y-4">
                    @csrf

                    @guest
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label for="guest_name" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Nama Anda *</label>
                                <input type="text" name="guest_name" id="guest_name" required value="{{ old('guest_name') }}"
                                    class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/80 px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="Contoh: Budi Santoso">
                                @error('guest_name')
                                    <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="guest_email" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Email Anda * (tidak dipublikasikan)</label>
                                <input type="email" name="guest_email" id="guest_email" required value="{{ old('guest_email') }}"
                                    class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/80 px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                                    placeholder="budi@example.com">
                                @error('guest_email')
                                    <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    @else
                        <div class="p-3 rounded-xl bg-zinc-100 dark:bg-zinc-800 text-xs text-zinc-600 dark:text-zinc-300 flex items-center gap-2">
                            <span>Berkomentar sebagai: <strong>{{ Auth::user()->name }}</strong> ({{ Auth::user()->email }})</span>
                        </div>
                    @endguest

                    <div>
                        <label for="comment" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Isi Komentar / Tanggapan *</label>
                        <textarea name="comment" id="comment" rows="4" required
                            class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800/80 p-3.5 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                            placeholder="Tuliskan komentar atau pertanyaan Anda dengan sopan..."></textarea>
                        @error('comment')
                            <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <button type="submit" 
                            class="px-5 py-2.5 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                            Kirim Komentar
                        </button>
                    </div>
                </form>
            </div>
        </section>

        <!-- Related Posts Section -->
        @if ($relatedPosts->count() > 0)
            <section class="mt-16 pt-10 border-t border-zinc-200 dark:border-zinc-800">
                <h3 class="text-base font-bold text-zinc-900 dark:text-zinc-100 mb-6">
                    Artikel Lain dalam Topik "{{ $post->category->name }}"
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                    @foreach ($relatedPosts as $rel)
                        <a href="{{ route('blog.show', $rel->slug) }}" class="group block p-4 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 hover:border-zinc-300 dark:hover:border-zinc-700 transition">
                            <span class="text-[10px] font-semibold text-indigo-600 dark:text-indigo-400">
                                {{ $rel->reading_time }} mnt baca
                            </span>
                            <h4 class="mt-1 text-xs font-bold text-zinc-900 dark:text-zinc-100 group-hover:text-indigo-600 dark:group-hover:text-indigo-400 transition line-clamp-2">
                                {{ $rel->title }}
                            </h4>
                            <p class="mt-1 text-[11px] text-zinc-400 line-clamp-2">
                                {{ Str::limit(strip_tags($rel->body), 80) }}
                            </p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

    </div>
</x-blog-layout>
