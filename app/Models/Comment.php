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
}
