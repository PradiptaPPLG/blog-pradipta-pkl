<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Menyimpan komentar baru dari pembaca (user login atau tamu).
     */
    public function store(Request $request, Post $post): RedirectResponse
    {
        $rules = [
            'comment' => ['required', 'string', 'min:3', 'max:1000'],
        ];

        // Jika pengunjung belum login, wajib isi nama & email
        if (!auth()->check()) {
            $rules['guest_name'] = ['required', 'string', 'max:100'];
            $rules['guest_email'] = ['required', 'email', 'max:150'];
        }

        $validated = $request->validate($rules);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'guest_name' => auth()->check() ? null : $validated['guest_name'],
            'guest_email' => auth()->check() ? null : $validated['guest_email'],
            'comment' => $validated['comment'],
            'is_approved' => true, // Default disetujui otomatis
        ]);

        return back()->with('success', 'Terima kasih! Komentar Anda berhasil diterbitkan.');
    }
}
