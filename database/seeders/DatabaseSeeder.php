<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database with realistic, high-quality data.
     */
    public function run(): void
    {
        // 1. Buat User Admin (Pradipta) & Rekan Penulis (Farhan)
        $admin = User::create([
            'name' => 'Pradipta Endra Maulana',
            'email' => 'admin@techpulse.id',
            'password' => Hash::make('password'),
            'role' => 'admin',
            'avatar' => 'images/ProfilePortifolioProfessional.jpg',
        ]);

        $author = User::create([
            'name' => 'Farhan Ramadhan',
            'email' => 'farhan@techpulse.id',
            'password' => Hash::make('password'),
            'role' => 'author',
            'avatar' => 'images/pp2.jpg',
        ]);

        // 2. Buat Kategori (Topik Beragam & Lengkap)
        $catWeb = Category::create([
            'name' => 'Web Development',
            'slug' => 'web-development',
            'description' => 'Tutorial, tren teknologi, dan arsitektur pengembangan web modern terkini.',
        ]);

        $catBackend = Category::create([
            'name' => 'Backend & Database',
            'slug' => 'backend-database',
            'description' => 'Mendalami perancangan API, arsitektur server, dan manajemen basis data relasional.',
        ]);

        $catPKL = Category::create([
            'name' => 'Karier & Tips PKL',
            'slug' => 'karier-tips-pkl',
            'description' => 'Panduan praktis dunia industri, magang, etos kerja programmer, dan portofolio.',
        ]);

        $catUIUX = Category::create([
            'name' => 'UI/UX & Frontend',
            'slug' => 'ui-ux-frontend',
            'description' => 'Seni merancang antarmuka pengguna yang bersih, responsif, intuitif, dan nyaman.',
        ]);

        $catDevOps = Category::create([
            'name' => 'DevOps & Deployment',
            'slug' => 'devops-deployment',
            'description' => 'CI/CD pipeline, konfigurasi serverless Vercel, Docker, dan deployment produksi.',
        ]);

        $catCyber = Category::create([
            'name' => 'Cyber Security',
            'slug' => 'cyber-security',
            'description' => 'Keamanan aplikasi web, autentikasi aman, proteksi OWASP, dan enkripsi data.',
        ]);

        $catMobile = Category::create([
            'name' => 'Mobile & PWA',
            'slug' => 'mobile-pwa',
            'description' => 'Pengembangan Progressive Web Apps dan integrasi mobile responsif modern.',
        ]);

        $catAI = Category::create([
            'name' => 'AI & Tools Coding',
            'slug' => 'ai-tools-coding',
            'description' => 'Pemanfaatan AI assistant untuk riset, refactoring, dan efisiensi produktivitas developer.',
        ]);

        // 3. Buat Tag
        $tagLaravel = Tag::create(['name' => 'Laravel', 'slug' => 'laravel']);
        $tagPHP = Tag::create(['name' => 'PHP', 'slug' => 'php']);
        $tagMySQL = Tag::create(['name' => 'MySQL', 'slug' => 'mysql']);
        $tagCleanCode = Tag::create(['name' => 'Clean Code', 'slug' => 'clean-code']);
        $tagTailwind = Tag::create(['name' => 'Tailwind CSS', 'slug' => 'tailwind-css']);
        $tagPKL = Tag::create(['name' => 'Tips PKL', 'slug' => 'tips-pkl']);
        $tagVercel = Tag::create(['name' => 'Vercel', 'slug' => 'vercel']);
        $tagSecurity = Tag::create(['name' => 'Web Security', 'slug' => 'web-security']);
        $tagGit = Tag::create(['name' => 'Git & GitHub', 'slug' => 'git-github']);

        // 4. Buat Artikel Realistis & Berkualitas Tinggi
        $postsData = [
            [
                'user_id' => $admin->id,
                'category_id' => $catPKL->id,
                'title' => 'Panduan Hari Pertama PKL untuk Siswa SMK PPLG: Mindset dan Langkah Nyata',
                'slug' => 'panduan-hari-pertama-pkl-smk-pplg',
                'thumbnail' => 'images/thumbnails/thumb_pkl.jpg',
                'status' => 'published',
                'views_count' => 142,
                'published_at' => now()->subDays(2),
                'tags' => [$tagPKL->id, $tagCleanCode->id],
                'body' => 'Hari pertama Praktik Kerja Lapangan (PKL) sering kali menjadi momen yang mendebarkan bagi siswa SMK jurusan Pengembangan Perangkat Lunak dan GIM (PPLG). Di sekolah kita terbiasa dengan soal latihan yang terukur, namun di industri kita dituntut untuk memahami alur kerja tim profesional.

### 1. Bangun Mindset Rasa Ingin Tahu dan Proaktif
Jangan menunggu instruksi datang jika kamu merasa tidak ada tugas. Tanyakan kepada pembimbing lapangan apa standar repository yang digunakan, konvensi penamaan commit di Git, serta arsitektur project yang sedang berjalan.

### 2. Aturan 20 Menit Sebelum Bertanya
Ketika kamu menghadapi kendala saat koding (misalnya error koneksi database atau syntax error):
1. Baca pesan error di konsol secara saksama.
2. Cari solusi di dokumentasi resmi atau forum pengembang.
3. Jika dalam 20 menit belum menemukan titik terang, bertanyalah kepada mentor dengan format: "Apa yang ingin dicapai, langkah apa yang sudah dicoba, dan di mana error-nya terjadi."

Sikap ini menunjukkan bahwa kamu menghargai waktu mentor sekaligus memiliki inisiatif problem-solving yang matang.',
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $catBackend->id,
                'title' => 'Mengapa Laravel Masih Menjadi Pilihan Utama Industri Web Modern',
                'slug' => 'mengapa-laravel-masih-menjadi-pilihan-utama-industri',
                'thumbnail' => 'images/thumbnails/thumb_laravel.jpg',
                'status' => 'published',
                'views_count' => 289,
                'published_at' => now()->subDay(),
                'tags' => [$tagLaravel->id, $tagPHP->id],
                'body' => 'Banyak yang mengira PHP sudah tertinggal, namun faktanya ekosistem PHP modern—terutama dengan sokongan framework Laravel—menjadi salah satu platform paling produktif dan stabil di industri perangkat lunak dunia.

### Keunggulan Arsitektur Laravel
Laravel tidak hanya menyediakan syntax yang elegan (*developer delight*), tetapi juga paket bawaan enterprise:
* **Eloquent ORM:** Memungkinkan manipulasi basis data dengan gaya object-oriented tanpa mengorbankan performa.
* **Database Migrations:** Memastikan kolaborasi antar programmer selalu sinkron pada struktur tabel yang sama.
* **Middleware & Security:** Perlindungan CSRF, SQL Injection prevention, serta sanitasi input sudah terintegrasi secara default.

Bagi siswa magang atau junior developer, menguasai fondasi Laravel dengan benar akan membuka pintu karier yang sangat luas baik di software house lokal maupun korporasi nasional.',
            ],
            [
                'user_id' => $author->id,
                'category_id' => $catBackend->id,
                'title' => 'Menghindari Masalah N+1 Query di Laravel Menggunakan Eager Loading',
                'slug' => 'menghindari-masalah-n-plus-1-query-laravel-eager-loading',
                'thumbnail' => 'images/thumbnails/thumb_nplus1.jpg',
                'status' => 'published',
                'views_count' => 97,
                'published_at' => now()->subHours(10),
                'tags' => [$tagLaravel->id, $tagMySQL->id, $tagCleanCode->id],
                'body' => 'Salah satu kesalahan paling lazim yang sering ditemukan dalam kode programmer pemula adalah **N+1 Query Problem**. Masalah ini terjadi ketika kita mengambil data induk, lalu memanggil relasi anak di dalam perulangan loop.

### Masalah Lazy Loading
Bayangkan kamu memiliki 50 postingan artikel, dan ingin menampilkan nama penulisnya:
```php
$posts = Post::all();
foreach ($posts as $post) {
    echo $post->user->name; // Mengeksekusi query baru di setiap iterasi!
}
```
Kode di atas akan mengeksekusi 1 query untuk mengambil post, dan 50 query tambahan ke tabel users. Total: 51 query!

### Solusi: Eager Loading dengan with()
Cukup tambahkan method `with()`:
```php
$posts = Post::with(\'user\', \'category\')->latest()->paginate(10);
```
Dengan eager loading, Laravel hanya menjalankan 2 query cepat secara efisien di balik layar, membuat respon aplikasi jauh lebih kencang.',
            ],
            [
                'user_id' => $author->id,
                'category_id' => $catUIUX->id,
                'title' => 'Prinsip Desain Web Modern: Clean, Fokus pada Konten, dan Ramah Pengguna',
                'slug' => 'prinsip-desain-web-modern-clean-dan-ramah-pengguna',
                'thumbnail' => 'images/thumbnails/thumb_uiux.jpg',
                'status' => 'published',
                'views_count' => 178,
                'published_at' => now()->subHours(5),
                'tags' => [$tagTailwind->id, $tagCleanCode->id],
                'body' => 'Desain web profesional bukan tentang menumpuk efek animasi berlebihan atau gradien warna neon yang menyilaukan. Desain yang baik adalah desain yang tidak terlihat—fokus utama langsung tertuju pada kemudahan membaca dan kecepatan navigasi pembaca.

### Fondasi Desain yang Matang
1. **Whitespace (Ruang Bernapas):** Berikan jarak yang cukup antar elemen. Konten yang padat membuat pembaca lelah secara visual.
2. **Tipografi Hierarkis:** Gunakan skala font yang jelas antara Judul (H1), Sub-judul (H2), dan Teks Paragraf.
3. **Warna Netral Berkualitas:** Gunakan palet abu-abu netral (seperti Zinc atau Slate di Tailwind) untuk latar dan teks sekunder, serta satu warna aksen yang konsisten.

Ketika estetika visual berpadu dengan performa halaman yang cepat, pengguna akan betah berlama-lama membaca artikel di web kita.',
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $catDevOps->id,
                'title' => 'Cara Deploy Laravel 12 ke Vercel Serverless Menggunakan Runtime Modern',
                'slug' => 'cara-deploy-laravel-12-ke-vercel-serverless',
                'thumbnail' => 'images/thumbnails/thumb_deploy_vercel_new.jpg',
                'status' => 'published',
                'views_count' => 312,
                'published_at' => now()->subHours(3),
                'tags' => [$tagVercel->id, $tagLaravel->id],
                'body' => 'Deploy Laravel ke platform serverless seperti Vercel sering dianggap rumit karena perbedaan arsitektur antara server konvensional (Apache/Nginx) dengan arsitektur stateless cloud.

### 1. Struktur Entry Point api/index.php
Vercel membutuhkan jembatan untuk mengeksekusi request HTTP ke kernel Laravel:
```php
require __DIR__ . \'/../public/index.php\';
```

### 2. Runtime vercel-php Modern
Pastikan menggunakan runtime yang mendukung fitur PHP 8.4 terbaru seperti Property Hooks agar dependency Symfony dan Laravel 12 tidak mengalami Parse Error saat kompilasi lambda.',
            ],
            [
                'user_id' => $author->id,
                'category_id' => $catCyber->id,
                'title' => '5 Celah Keamanan Web Paling Umum dan Cara Mencegahnya di Laravel',
                'slug' => 'celah-keamanan-web-dan-pencegahan-laravel',
                'thumbnail' => 'images/thumbnails/thumb_cyber_security_new.jpg',
                'status' => 'published',
                'views_count' => 205,
                'published_at' => now()->subHours(2),
                'tags' => [$tagSecurity->id, $tagLaravel->id, $tagCleanCode->id],
                'body' => 'Keamanan aplikasi web bukan sekadar fitur tambahan, melainkan pondasi utama setiap sistem perangkat lunak yang layak produksi.

### 1. Cross-Site Scripting (XSS)
Laravel secara bawaan menggunakan Blade template syntax `{{ $variable }}` yang otomatis memanggil `htmlspecialchars()` untuk membersihkan script berbahaya.

### 2. SQL Injection
Gunakan selalu Eloquent ORM atau parameter binding PDO daripada menulis query mentah dengan konkatenasi string manual.',
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $catMobile->id,
                'title' => 'Membangun Web Responsif dengan Tailwind CSS: Mobile-First Strategy',
                'slug' => 'membangun-web-responsif-tailwind-mobile-first',
                'thumbnail' => 'images/thumbnails/thumb_uiux.jpg',
                'status' => 'published',
                'views_count' => 164,
                'published_at' => now()->subHour(),
                'tags' => [$tagTailwind->id, $tagCleanCode->id],
                'body' => 'Lebih dari 70% pengunjung website membaca konten melalui layar smartphone. Oleh karena itu, pendekatan **Mobile-First** bukan lagi pilihan, melainkan keharusan standar industri.

### Konsep Breakpoint di Tailwind
Tailwind menerapkan konsep mobile-first: class tanpa prefix (seperti `p-4 text-sm`) berlaku untuk layar terkecil HP, sedangkan prefix seperti `sm:`, `md:`, dan `lg:` hanya diterapkan saat ukuran layar membesar.',
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $catAI->id,
                'title' => 'Pemanfaatan AI Coding Assistant untuk Riset dan Refactoring Tanpa Kehilangan Esensi Belajar',
                'slug' => 'pemanfaatan-ai-coding-assistant-untuk-developer-muda',
                'thumbnail' => 'images/thumbnails/thumb_pkl.jpg',
                'status' => 'published',
                'views_count' => 248,
                'published_at' => now()->subMinutes(30),
                'tags' => [$tagCleanCode->id, $tagPKL->id],
                'body' => 'Kecerdasan Buatan (AI) telah mengubah cara developer menulis kode. Namun, bagi siswa SMK dan junior programmer, AI harus diposisikan sebagai partner diskusi dan mentor virtual, bukan tombol pintas copy-paste tanpa pemahaman.

### Cara Efektif Menggunakan AI:
1. Minta AI menjelaskan alur kerja dari sebuah potongan kode yang belum dimengerti.
2. Gunakan untuk mereview celah keamanan dan potensi bottleneck query database.
3. Selalu uji dan verifikasi manual setiap logika kode yang dihasilkan.',
            ],
            [
                'user_id' => $admin->id,
                'category_id' => $catWeb->id,
                'title' => 'Konvensi Git Commit yang Rapi Agar Disukai Tim Tech Lead',
                'slug' => 'konvensi-git-commit-rapi-disukai-tech-lead',
                'thumbnail' => 'images/thumbnails/thumb_laravel.jpg',
                'status' => 'draft',
                'views_count' => 0,
                'published_at' => null,
                'tags' => [$tagCleanCode->id, $tagPKL->id],
                'body' => 'Catatan commit di Git adalah dokumentasi perjalanan sebuah software. Menulis pesan commit seperti "update", "fix error", atau "bisa" adalah tanda kurang profesionalnya seorang developer. Gunakan format konvensional seperti feat, fix, refactor, dan docs.',
            ],
        ];

        foreach ($postsData as $data) {
            $tags = $data['tags'];
            unset($data['tags']);

            $post = Post::create($data);
            $post->tags()->sync($tags);

            // Tambahkan komentar diskusi
            if ($post->status === 'published') {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => $author->id,
                    'comment' => 'Penjelasan yang sangat padat dan relevan untuk teman-teman yang baru mulai magang industri. Keren, Dipta!',
                    'is_approved' => true,
                ]);

                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => null,
                    'guest_name' => 'Rian Ardiansyah',
                    'guest_email' => 'rian.ardiansyah@smkn1ciamis.sch.id',
                    'comment' => 'Sangat membantu penjelasannya! Ini materi yang pas banget buat persiapan anak PPLG sebelum terjun magang.',
                    'is_approved' => true,
                ]);
            }
        }
    }
}
