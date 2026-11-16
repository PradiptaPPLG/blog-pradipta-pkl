<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
        'guest_name',
        'guest_email',
        'comment',
        'is_approved',
    ];

    protected function casts(): array
    {
        return [
            'is_approved' => 'boolean',
        ];
    }

    /**
     * Artikel tempat komentar ini ditulis.
     */
    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * User yang menulis komentar (jika sedang login).
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Helper accessor untuk mendapatkan nama pembuat komentar.
     */
    public function getAuthorNameAttribute(): string
    {
        if ($this->user) {
            return $this->user->name;
        }

        return $this->guest_name ?: 'Pengunjung';
    }

    /**
     * Helper accessor untuk mendapatkan avatar pembuat komentar (baik member maupun guest).
     */
    public function getAvatarUrlAttribute(): string
    {
        if ($this->user && $this->user->avatar_url) {
            return $this->user->avatar_url;
        }

        // Tentukan foto profil guest berdasarkan nama agar konsisten (pp1 - pp5)
        $avatars = [
            'images/pp1.jpg',
            'images/pp3.jpg',
            'images/pp4.jpg',
            'images/pp5.jpg',
        ];

        $hash = crc32($this->guest_name ?? 'Guest') % count($avatars);
        return asset($avatars[abs($hash)]);
    }
}
