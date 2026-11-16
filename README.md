# TechPulse — Modern Laravel Blog Platform

> **Proyek Tugas Hari Ke-1 Praktik Kerja Lapangan (PKL)**  
> **Pengembang:** Pradipta Endra Maulana (XI PPLG - SMKN 1 Ciamis)  
> **Teknologi:** Laravel 12, MySQL, Tailwind CSS, Blade Components, Laravel Breeze

---

## 🌟 Tentang Proyek
**TechPulse** adalah sistem manajemen konten (CMS) dan platform blog publikasi teknologi yang dirancang dengan standar rekayasa perangkat lunak modern. Dibangun dengan memprioritaskan estetika visual yang matang, hirarki tipografi yang bersih, serta arsitektur kode modular yang bebas dari pola *spaghetti code* atau *AI slop*.

---

## 🚀 Fitur Utama

### 1. Halaman Publik (Pengunjung)
* **Beranda Publik & Pagination:** Menampilkan feed artikel terkini dengan tata letak majalah digital yang nyaman dibaca.
* **Filter Dinamis:** Pengelompokan artikel berdasarkan kategori dan topik tag dengan query string yang bersih.
* **Fitur Pencarian:** Cari artikel berdasarkan kata kunci judul maupun isi konten secara instan.
* **Halaman Baca Artikel (Single Post):** Dilengkapi kalkulasi otomatis estimasi waktu membaca (*reading time*), indikator views counter, breadcrumb navigasi, dan card profil penulis.
* **Sistem Diskusi / Komentar:** Pembaca (baik pengunjung tamu maupun member login) dapat meninggalkan komentar dan tanggapan secara langsung.

### 2. Panel CMS & Administrasi (Admin / Author)
* **Dashboard Statistik:** Ringkasan jumlah artikel, status publikasi (*Published* vs *Draft*), akumulasi views, total kategori, dan moderasi komentar.
* **Manajemen Artikel (CRUD Lengkap):**
  * Auto-generate *slug* unik ramah SEO dari judul artikel.
  * Validasi dan upload gambar thumbnail ke storage publik.
  * Dukungan status publikasi (*Draft* atau *Published*).
  * Relasi banyak-ke-banyak (*Many-to-Many*) dengan tag topik.
* **Manajemen Kategori:** Tambah dan kelola kategori artikel. Proteksi penghapusan otomatis jika kategori masih memiliki artikel terkait.
* **Moderasi Komentar:** Kemampuan menyetujui, menyembunyikan, atau menghapus komentar pengunjung.

---

## 🏗️ Arsitektur & Best Practices Kode
* **Pencegahan N+1 Query:** Mengimplementasikan **Eager Loading** (`with(['user', 'category', 'tags'])`) pada setiap pemanggilan query relasional.
* **Modular Blade Components:** Memisahkan layout publik (`<x-blog-layout>`) dan layout admin (`<x-app-layout>`) secara terstruktur (*DRY - Don't Repeat Yourself*).
* **Database Relasional & Foreign Key:** Seluruh relasi tabel (`users`, `categories`, `posts`, `tags`, `post_tag`, `comments`) terikat integritas referensial dengan `cascadeOnDelete()` dan `nullOnDelete()`.

---

## 🔐 Kredensial Akun Demo (Testing)

Database sudah dilengkapi seeder data realistis dan akun pengujian:

| Peran (Role) | Email | Password |
|---|---|---|
| **Administrator** | `admin@techpulse.id` | `password` |
| **Penulis (Author)** | `sarah@techpulse.id` | `password` |

---

## ⚙️ Panduan Menjalankan Aplikasi

Pastikan XAMPP (Apache & MySQL) sudah aktif di komputer Anda:

```bash
# 1. Pindah ke direktori project
cd blog-pkl

# 2. Instalasi dependensi PHP & Node.js (jika baru di-clone)
composer install
npm install

# 3. Hubungkan Storage Link untuk thumbnail gambar
php artisan storage:link

# 4. Migrasi database dan isi data awal (Seeder)
php artisan migrate:fresh --seed

# 5. Kompilasi aset CSS / JS
npm run build

# 6. Jalankan server lokal Laravel
php artisan serve
```

Aplikasi dapat langsung diakses di browser melalui:  
👉 **Web Publik:** `http://localhost:8000`  
👉 **Login CMS:** `http://localhost:8000/login`
