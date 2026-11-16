<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h2 class="font-extrabold text-xl text-zinc-900 dark:text-zinc-100 leading-tight">
                    Manajemen Artikel (Posts)
                </h2>
                <p class="text-xs text-zinc-500 mt-1">
                    Kelola seluruh konten, publikasi artikel, serta draft tulisan.
                </p>
            </div>
            <a href="{{ route('admin.posts.create') }}" 
               class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tulis Artikel Baru
            </a>
        </div>
    </x-slot>

    <!-- Filter & Search Toolbar -->
    <div class="mb-6 p-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm">
        <form action="{{ route('admin.posts.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-center">
            
            <!-- Input Search -->
            <div class="sm:col-span-5 relative">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul artikel..." 
                    class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 px-3.5 py-2 pl-9 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <svg class="w-4 h-4 text-zinc-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>

            <!-- Filter Category -->
            <div class="sm:col-span-3">
                <select name="category_id" class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 px-3 py-2 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Filter Status -->
            <div class="sm:col-span-2">
                <select name="status" class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 px-3 py-2 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    <option value="">Semua Status</option>
                    <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>Published</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                </select>
            </div>

            <!-- Buttons -->
            <div class="sm:col-span-2 flex items-center gap-2">
                <button type="submit" class="w-full px-3 py-2 text-xs font-semibold rounded-xl bg-zinc-900 text-white dark:bg-white dark:text-zinc-900 hover:opacity-90 transition">
                    Filter
                </button>
                @if (request('search') || request('category_id') || request('status'))
                    <a href="{{ route('admin.posts.index') }}" class="px-3 py-2 text-xs font-semibold rounded-xl bg-zinc-100 text-zinc-600 dark:bg-zinc-800 dark:text-zinc-400 hover:bg-zinc-200 transition">
                        Reset
                    </a>
                @endif
            </div>

        </form>
    </div>

    <!-- Table Posts -->
    <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-800 text-zinc-400 font-semibold uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Artikel</th>
                        <th class="py-3 px-4">Kategori</th>
                        <th class="py-3 px-4">Penulis</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Views</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 font-medium">
                    @forelse ($posts as $post)
                        <tr class="hover:bg-zinc-50/60 dark:hover:bg-zinc-800/30 transition">
                            <td class="py-3.5 px-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-12 h-9 rounded-lg object-cover shrink-0 border border-zinc-200 dark:border-zinc-700">
                                    <div class="max-w-xs sm:max-w-md">
                                        <div class="font-bold text-zinc-900 dark:text-zinc-100 line-clamp-1">{{ $post->title }}</div>
                                        <div class="text-[10px] text-zinc-400 font-mono mt-0.5">/posts/{{ $post->slug }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <span class="px-2 py-0.5 rounded text-[10px] bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300 font-semibold">
                                    {{ $post->category->name }}
                                </span>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-zinc-600 dark:text-zinc-400">
                                {{ $post->user->name }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if ($post->status === 'published')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                        Published
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300">
                                        Draft
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap font-mono text-zinc-500">
                                {{ number_format($post->views_count) }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-zinc-400 text-[11px]">
                                {{ $post->created_at->format('d M Y') }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-2">
                                    @if ($post->status === 'published')
                                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" title="Lihat di Web"
                                           class="p-1.5 text-zinc-400 hover:text-zinc-600 dark:hover:text-zinc-200 transition">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                                        </a>
                                    @endif

                                    <a href="{{ route('admin.posts.edit', $post->id) }}" 
                                       class="px-2.5 py-1 rounded-lg text-xs font-semibold text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950 hover:bg-indigo-100 transition">
                                        Edit
                                    </a>

                                    <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus artikel ini? Tindakan ini tidak dapat dibatalkan.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950 hover:bg-rose-100 transition">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-10 text-center text-zinc-400">
                                Tidak ada artikel yang sesuai dengan filter pencarian.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($posts->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                {{ $posts->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
