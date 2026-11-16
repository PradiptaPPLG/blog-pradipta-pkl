<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'title',
        'slug',
        'thumbnail',
        'body',
        'status',
        'views_count',
        'published_at',
    ];

    protected function casts(): array
    {
        return [
            'published_at' => 'datetime',
            'views_count' => 'integer',
        ];
    }

    /**
     * Penulis artikel.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Kategori artikel.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Tag yang terpasang pada artikel ini.
     */
    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'post_tag');
    }

    /**
     * Komentar pada artikel ini.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Komentar yang sudah disetujui.
     */
    public function approvedComments(): HasMany
    {
        return $this->hasMany(Comment::class)->where('is_approved', true);
    }

    /**
     * Scope untuk artikel yang sudah berstatus 'published'.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    /**
     * Scope filter pencarian dan kategori.
     */
    public function scopeFilter(Builder $query, array $filters): Builder
    {
        // Filter pencarian teks judul atau konten
        $query->when($filters['search'] ?? false, function ($q, $search) {
            $q->where(function ($sub) use ($search) {
                $sub->where('title', 'like', '%' . $search . '%')
                    ->orWhere('body', 'like', '%' . $search . '%');
            });
        });

        // Filter berdasarkan slug kategori
        $query->when($filters['category'] ?? false, function ($q, $categorySlug) {
            $q->whereHas('category', function ($sub) use ($categorySlug) {
                $sub->where('slug', $categorySlug);
            });
        });

        // Filter berdasarkan slug tag
        $query->when($filters['tag'] ?? false, function ($q, $tagSlug) {
            $q->whereHas('tags', function ($sub) use ($tagSlug) {
                $sub->where('slug', $tagSlug);
            });
        });

        return $query;
    }

    /**
     * Estimasi waktu membaca (kata / 200 wpm).
     */
    public function getReadingTimeAttribute(): int
    {
        $words = str_word_count(strip_tags($this->body));
        $minutes = ceil($words / 200);
        return max(1, (int) $minutes);
    }

    /**
     * URL Gambar Thumbnail dengan fallback placeholder yang elegan.
     */
    public function getThumbnailUrlAttribute(): string
    {
        if ($this->thumbnail) {
            if (str_starts_with($this->thumbnail, 'images/') || str_starts_with($this->thumbnail, 'http')) {
                return asset($this->thumbnail);
            }
            if (file_exists(public_path('storage/' . $this->thumbnail))) {
                return asset('storage/' . $this->thumbnail);
            }
            return asset('storage/' . $this->thumbnail);
        }

        // Placeholder default jika artikel belum memiliki gambar
        return 'https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=1200&q=80';
    }
}
