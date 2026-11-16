<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-xl text-zinc-900 dark:text-zinc-100 leading-tight">
                Manajemen Kategori
            </h2>
            <p class="text-xs text-zinc-500 mt-1">
                Kelola taksonomi topik untuk mengelompokkan artikel di blog.
            </p>
        </div>
    </x-slot>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        
        <!-- Daftar Kategori (8 cols) -->
        <div class="lg:col-span-8 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-zinc-200 dark:border-zinc-800">
                <h3 class="font-bold text-sm text-zinc-900 dark:text-zinc-100">Kategori Tersedia</h3>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-800 text-zinc-400 font-semibold uppercase tracking-wider text-[10px]">
                            <th class="py-3 px-4">Nama Kategori</th>
                            <th class="py-3 px-4">Slug</th>
                            <th class="py-3 px-4">Deskripsi</th>
                            <th class="py-3 px-4">Jumlah Artikel</th>
                            <th class="py-3 px-4 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 font-medium">
                        @foreach ($categories as $cat)
                            <tr class="hover:bg-zinc-50/60 dark:hover:bg-zinc-800/30 transition">
                                <td class="py-3.5 px-4 font-bold text-zinc-900 dark:text-zinc-100">
                                    {{ $cat->name }}
                                </td>
                                <td class="py-3.5 px-4 font-mono text-zinc-400 text-[11px]">
                                    {{ $cat->slug }}
                                </td>
                                <td class="py-3.5 px-4 text-zinc-500 max-w-xs truncate">
                                    {{ $cat->description ?: '-' }}
                                </td>
                                <td class="py-3.5 px-4">
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[10px] font-semibold bg-zinc-100 dark:bg-zinc-800 text-zinc-700 dark:text-zinc-300">
                                        {{ $cat->posts_count }} artikel
                                    </span>
                                </td>
                                <td class="py-3.5 px-4 text-right">
                                    @if ($cat->posts_count == 0)
                                        <form action="{{ route('admin.categories.destroy', $cat->id) }}" method="POST" 
                                              onsubmit="return confirm('Hapus kategori ini?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:text-rose-800 font-semibold">
                                                Hapus
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-[11px] text-zinc-400" title="Kategori sedang digunakan oleh artikel">Terkunci</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Form Tambah Kategori (4 cols) -->
        <div class="lg:col-span-4 rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 p-6 shadow-sm">
            <h3 class="font-bold text-sm text-zinc-900 dark:text-zinc-100 mb-4">Tambah Kategori Baru</h3>

            <form action="{{ route('admin.categories.store') }}" method="POST" class="space-y-4">
                @csrf

                <div>
                    <label for="name" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Nama Kategori *</label>
                    <input type="text" name="name" id="name" required value="{{ old('name') }}"
                        class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 px-3.5 py-2.5 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Contoh: Mobile Development">
                    @error('name')
                        <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="description" class="block text-xs font-semibold text-zinc-700 dark:text-zinc-300 mb-1.5">Deskripsi Singkat</label>
                    <textarea name="description" id="description" rows="3"
                        class="w-full text-xs rounded-xl border border-zinc-300 dark:border-zinc-700 bg-zinc-50 dark:bg-zinc-800 px-3.5 py-2 text-zinc-900 dark:text-zinc-100 focus:outline-none focus:ring-2 focus:ring-indigo-500"
                        placeholder="Penjelasan ringkas mengenai cakupan kategori ini...">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="mt-1 text-[11px] text-rose-500">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit" 
                    class="w-full py-2.5 rounded-xl text-xs font-semibold text-white bg-indigo-600 hover:bg-indigo-700 shadow-sm transition">
                    + Tambah Kategori
                </button>
            </form>
        </div>

    </div>
</x-app-layout>
