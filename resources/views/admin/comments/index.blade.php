<x-app-layout>
    <x-slot name="header">
        <div>
            <h2 class="font-extrabold text-xl text-zinc-900 dark:text-zinc-100 leading-tight">
                Moderasi Komentar
            </h2>
            <p class="text-xs text-zinc-500 mt-1">
                Tinjau, setujui, atau hapus tanggapan dan komentar yang dikirim oleh pembaca.
            </p>
        </div>
    </x-slot>

    <div class="rounded-2xl bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="bg-zinc-50 dark:bg-zinc-800/60 border-b border-zinc-200 dark:border-zinc-800 text-zinc-400 font-semibold uppercase tracking-wider text-[10px]">
                        <th class="py-3 px-4">Pengirim</th>
                        <th class="py-3 px-4">Isi Komentar</th>
                        <th class="py-3 px-4">Pada Artikel</th>
                        <th class="py-3 px-4">Status</th>
                        <th class="py-3 px-4">Tanggal</th>
                        <th class="py-3 px-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800/60 font-medium">
                    @forelse ($comments as $comment)
                        <tr class="hover:bg-zinc-50/60 dark:hover:bg-zinc-800/30 transition">
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                <div class="font-bold text-zinc-900 dark:text-zinc-100">{{ $comment->author_name }}</div>
                                <div class="text-[10px] text-zinc-400">
                                    {{ $comment->user ? 'Member (' . $comment->user->email . ')' : ($comment->guest_email ?: 'Tamu') }}
                                </div>
                            </td>
                            <td class="py-3.5 px-4 max-w-sm">
                                <p class="text-zinc-700 dark:text-zinc-300 line-clamp-2 leading-relaxed">
                                    {{ $comment->comment }}
                                </p>
                            </td>
                            <td class="py-3.5 px-4 max-w-xs truncate">
                                <a href="{{ route('blog.show', $comment->post->slug) }}" target="_blank" 
                                   class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                    {{ $comment->post->title }}
                                </a>
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap">
                                @if ($comment->is_approved)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-300">
                                        Disetujui
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-[10px] font-semibold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-300">
                                        Disembunyikan
                                    </span>
                                @endif
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-zinc-400 text-[11px]">
                                {{ $comment->created_at->diffForHumans() }}
                            </td>
                            <td class="py-3.5 px-4 whitespace-nowrap text-right space-x-2">
                                <form action="{{ route('admin.comments.toggle', $comment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" 
                                        class="px-2.5 py-1 rounded-lg text-xs font-semibold {{ $comment->is_approved ? 'text-amber-600 bg-amber-50 hover:bg-amber-100' : 'text-emerald-600 bg-emerald-50 hover:bg-emerald-100' }} transition">
                                        {{ $comment->is_approved ? 'Sembunyikan' : 'Setujui' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.comments.destroy', $comment->id) }}" method="POST" 
                                      onsubmit="return confirm('Hapus komentar ini?');" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-2.5 py-1 rounded-lg text-xs font-semibold text-rose-600 bg-rose-50 hover:bg-rose-100 transition">
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-10 text-center text-zinc-400">
                                Belum ada komentar yang masuk.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($comments->hasPages())
            <div class="p-4 border-t border-zinc-200 dark:border-zinc-800">
                {{ $comments->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
