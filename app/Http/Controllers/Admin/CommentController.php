<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CommentController extends Controller
{
    /**
     * Menampilkan daftar komentar dari semua artikel.
     */
    public function index(Request $request): View
    {
        $comments = Comment::with(['post', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.comments.index', compact('comments'));
    }

    /**
     * Mengubah status persetujuan komentar (Approve / Reject).
     */
    public function toggleApprove(Comment $comment): RedirectResponse
    {
        $comment->is_approved = !$comment->is_approved;
        $comment->save();

        $statusText = $comment->is_approved ? 'disetujui' : 'disembunyikan';
        return back()->with('success', "Status komentar berhasil {$statusText}.");
    }

    /**
     * Menghapus komentar.
     */
    public function destroy(Comment $comment): RedirectResponse
    {
        $comment->delete();

        return back()->with('success', 'Komentar berhasil dihapus.');
    }
}
