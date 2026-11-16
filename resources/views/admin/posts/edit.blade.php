<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="font-extrabold text-xl text-zinc-900 dark:text-zinc-100 leading-tight">
                    Edit Artikel: {{ Str::limit($post->title, 40) }}
                </h2>
                <p class="text-xs text-zinc-500 mt-1">
                    Perbarui judul, isi, gambar sampul, atau ubah status artikel ini.
                </p>
            </div>
            <a href="{{ route('admin.posts.index') }}" class="text-xs font-semibold text-zinc-500 hover:text-zinc-700 dark:hover:text-zinc-300">
                ← Kembali ke Daftar Artikel
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto">
        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data" 
              class="space-y-6 bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl p-6 sm:p-8 shadow-sm">
            @csrf
            @method('PUT')

            <!-- Judul Artikel -->
            <div>
                <label for="title" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-2">
                    Judul Artikel *
                </label>
                <input type="text" name="title" id="title" required value="{{ old('title', $post->title) }}"
                    class="w-full text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 p-3.5 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <p class="mt-1.5 text-[11px] text-zinc-400 font-mono">Slug saat ini: /posts/{{ $post->slug }}</p>
                @error('title')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Kategori & Status (2 Columns) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="category_id" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-2">
                        Kategori Artikel *
                    </label>
                    <select name="category_id" id="category_id" required
                        class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 p-3 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}" {{ old('category_id', $post->category_id) == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="status" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-2">
                        Status Publikasi *
                    </label>
                    <select name="status" id="status" required
                        class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 p-3 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        <option value="draft" {{ old('status', $post->status) === 'draft' ? 'selected' : '' }}>Draft (Simpan Sementara)</option>
                        <option value="published" {{ old('status', $post->status) === 'published' ? 'selected' : '' }}>Published (Terbitkan)</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Upload Thumbnail Gambar -->
            <div>
                <label for="thumbnail" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-2">
                    Foto Sampul / Thumbnail
                </label>
                
                @if ($post->thumbnail)
                    <div class="mb-3 flex items-center gap-3 p-3 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800">
                        <img src="{{ $post->thumbnail_url }}" alt="Current thumbnail" class="w-16 h-12 object-cover rounded-lg border">
                        <span class="text-xs text-zinc-500">File thumbnail saat ini terpasang. Pilih file baru jika ingin menggantinya.</span>
                    </div>
                @endif

                <input type="file" name="thumbnail" id="thumbnail" accept="image/jpeg,image/png,image/webp"
                    class="block w-full text-xs text-zinc-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-zinc-100 dark:file:bg-zinc-800 file:text-zinc-700 dark:file:text-zinc-300 hover:file:bg-zinc-200 cursor-pointer">
                @error('thumbnail')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Tags Multi-Select -->
            @if ($tags->count() > 0)
                <div>
                    <label class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-2">
                        Pilih Tag / Topik Relevan
                    </label>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $currentTagIds = $post->tags->pluck('id')->toArray();
                        @endphp
                        @foreach ($tags as $tag)
                            <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl border border-zinc-200 dark:border-zinc-800 bg-zinc-50 dark:bg-zinc-800/60 cursor-pointer hover:bg-zinc-100 transition text-xs">
                                <input type="checkbox" name="tags[]" value="{{ $tag->id }}" 
                                    {{ in_array($tag->id, old('tags', $currentTagIds)) ? 'checked' : '' }}
                                    class="rounded border-zinc-300 text-indigo-600 focus:ring-indigo-500">
                                <span class="text-zinc-700 dark:text-zinc-300 font-medium">#{{ $tag->name }}</span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Isi Konten Artikel -->
            <div>
                <label for="body" class="block text-xs font-bold uppercase tracking-wider text-zinc-700 dark:text-zinc-300 mb-2">
                    Isi Artikel *
                </label>
                <textarea name="body" id="body" rows="14" required
                    class="w-full text-sm rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 p-4 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500 leading-relaxed font-mono">{{ old('body', $post->body) }}</textarea>
                @error('body')
                    <p class="mt-1 text-xs text-rose-500">{{ $message }}</p>
                @enderror
            </div>

            <!-- Action Buttons -->
            <div class="pt-4 border-t border-zinc-200 dark:border-zinc-800 flex items-center justify-between">
                <div>
                    @if ($post->status === 'published')
                        <a href="{{ route('blog.show', $post->slug) }}" target="_blank" class="text-xs text-indigo-600 dark:text-indigo-400 font-semibold hover:underline">
                            Lihat Halaman Publik ↗
                        </a>
                    @endif
                </div>
                <div class="flex items-center gap-3">
                    <a href="{{ route('admin.posts.index') }}" 
                       class="px-4 py-2.5 rounded-xl text-xs font-semibold text-zinc-600 dark:text-zinc-400 hover:bg-zinc-100 dark:hover:bg-zinc-800 transition">
                        Batal
                    </a>
                    <button type="submit" 
                        class="px-6 py-2.5 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-app-layout>
