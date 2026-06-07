# 🌾 CatatPanen: Dokumentasi Spesifikasi Proyek & Manajemen Sistem

Dokumen ini merupakan bentuk luaran formal dari manajemen proyek perangkat lunak (**MPPL**) yang mengintegrasikan *Project Charter*, Dokumen Persyaratan, Alur Bisnis, dan Arsitektur Basis Data untuk pengembangan aplikasi **CatatPanen**.

---

## 📋 1. Informasi Umum Proyek

| Komponen Proyek | Deskripsi Detil |
| :--- | :--- |
| **Judul Proyek** | CatatPanen: Solusi Digitalisasi Manajemen Data Hasil Pertanian |
| **Instansi** | Program Studi Informatika, Universitas Sulawesi Barat |
| **Teknologi Utama** | Laravel Framework, MySQL, PHP, Tailwind CSS, Vite |
| **Lokasi Target** | Regional Polewali Mandar, Sulawesi Barat |

### 👥 Struktur Tim Pelaksana
1. **Project Manager (PM):** Hasnur (NIM: D0223509)
   * *Tanggung Jawab:* Koordinasi strategis, manajemen risiko, analisis kebutuhan, pengawasan kepatuhan kualitas, dan pengendalian jadwal proyek.
2. **Developer:** Muhammad Ali Sadikin (NIM: D0223332)
   * *Tanggung Jawab:* Eksekusi arsitektur teknis, implementasi basis data, pengembangan komponen *Front-end* (Blade & Tailwind) serta *Back-end* (Laravel Core).

---

## 🎯 2. Latar Belakang & Tujuan Bisnis

### Latar Belakang
Proses pencatatan hasil pertanian (khususnya komoditas gabah/padi) di kelompok tani regional Polewali Mandar saat ini masih didominasi oleh metode konvensional (buku besar manual/kertas). Hal ini menimbulkan kerentanan sistemik seperti:
* **Integritas Data Rendah:** Risiko kehilangan data akibat kerusakan fisik media kertas.
* **Redundansi & Ketidakkonsistenan:** Variasi penulisan nama varietas komoditas secara manual yang memicu kesalahan rekapitulasi.
* **Keterbatasan Analisis:** Lambatnya pencarian data historis untuk mendeteksi tren produktivitas lahan pertanian secara temporal.

### Tujuan Proyek
1. Membangun infrastruktur manajemen data digital yang mampu menyimpan catatan hasil panen secara terstruktur dan terpusat.
2. Memitigasi *human error* melalui standardisasi input berbasis master data.
3. Menyediakan dasbor analitik real-time yang menyajikan visualisasi data terverifikasi bagi pemangku kepentingan.

---

## 🕹️ 3. Cakupan Sistem & Fitur Utama (MVP)

Sistem diimplementasikan menggunakan kontrol akses berbasis peran (**Role-Based Access Control / RBAC**) yang membagi hak akses ke dalam 3 tingkatan utama:

### A. Fitur Petani (Data Creator)
* **Autentikasi Pengguna:** Login ke portal khusus petani.
* **Pencatatan Setoran Panen harian:** Menginput tanggal panen dan berat gabah (dalam satuan Kilogram).
* **Standardisasi Komoditas:** Memilih jenis padi melalui elemen *dropdown* yang terhubung langsung ke tabel master varietas untuk menghindari salah ketik.
* **Pelacakan Riwayat Sesi:** Melihat riwayat setoran panen yang dikirimkan beserta status validasinya (`Pending` / `Verified`).

### B. Fitur Admin (Data Verifier)
* **Manajemen Validasi:** Memeriksa pengajuan pencatatan panen dari petani lokal yang berstatus `Pending`.
* **Verifikasi Data:** Mengubah status transaksi menjadi `Verified` setelah dilakukan pengecekan fisik/kuantitas di lapangan.
* **Manajemen Master Data:** Mengelola data varietas padi (Tambah, Ubah, Hapus jenis padi resmi).

### C. Fitur Super Admin (System Supervisor & Consumer)
* **Dashboard Analitik Eksekutif:** Memantau visualisasi tren hasil produksi padi bulanan dan produktivitas regional berdasarkan data yang telah divalidasi.
* **Jejak Audit (Audit Trail):** Melacak akuntabilitas proses verifikasi karena sistem secara otomatis mencatat ID Admin yang mengubah status transaksi dari `Pending` menjadi `Verified`.

---

## 🔄 4. Alur Proses Bisnis (System Flow)

1. **Tahap Input (Petani):**
   Petani masuk ke sistem $\rightarrow$ Mengisi form panen harian $\rightarrow$ Memilih varietas padi dari daftar *dropdown* master $\rightarrow$ Data disimpan di database dengan status default `'Pending'` dan kolom `admin_id` bernilai `NULL`.
   
2. **Tahap Verifikasi (Admin):**
   Admin memeriksa antrean data berstatus `'Pending'` $\rightarrow$ Melakukan validasi $\rightarrow$ Mengubah status menjadi `'Verified'`. Secara otomatis, sistem merekam `admin_id` ke dalam baris data tersebut sebagai akuntabilitas kerja.

3. **Tahap Analisis (Super Admin):**
   Sistem secara dinamis menyaring data hasil panen yang berstatus `'Verified'` $\rightarrow$ Melakukan agregasi statistik $\rightarrow$ Menyajikan visualisasi grafik tren produksi bulanan pada *Dashboard* utama Super Admin.

---

## 🗄️ 5. Arsitektur Basis Data (Skema Relasional)

Rancangan basis data telah memenuhi kaidah **Normalisasi Database** untuk menjamin efisiensi penyimpanan data tanpa redundansi.

### 1. Tabel: `users`
Menampung data kredensial dan peran seluruh pengguna sistem.
* `id` (INT, Primary Key, Auto Increment)
* `name` (VARCHAR) - Nama lengkap pengguna.
* `email` (VARCHAR, Unique) - Alamat surel unik untuk autentikasi.
* `password` (VARCHAR) - Kata sandi yang diamankan menggunakan enkripsi hashing (Bcrypt).
* `role` (ENUM: `'Super Admin'`, `'Admin'`, `'Petani'`) - Penentu hak akses RBAC.
* `created_at` (TIMESTAMP)

### 2. Tabel: `varietas_padi`
Tabel master referensi jenis padi guna menghindari pengetikan bebas (*human error*).
* `id` (INT, Primary Key, Auto Increment)
* `nama_varietas` (VARCHAR, Unique) - Contoh: IR64, Ciherang, Inpari, Pandan Wangi.
* `deskripsi` (TEXT, Nullable)
* `created_at` (TIMESTAMP)

### 3. Tabel: `hasil_panen`
Tabel transaksional utama pencatatan hasil produksi harian.
* `id` (INT, Primary Key, Auto Increment)
* `user_id` (INT, Foreign Key $\rightarrow$ `users.id`) - Menunjuk petani pembuat entri.
* `varietas_id` (INT, Foreign Key $\rightarrow$ `varietas_padi.id`) - Menunjuk jenis padi yang dipilih dari master data.
* `berat_gabah_kg` (DECIMAL(8,2)) - Total berat panen terukur.
* `tanggal_panen` (DATE) - Atribut temporalitas pelaksanaan panen.
* `status_verifikasi` (ENUM: `'Pending'`, `'Verified'`) - Default: `'Pending'`.
* `admin_id` (INT, Nullable, Foreign Key $\rightarrow$ `users.id`) - Berisi ID Admin pemverifikasi data (terisi setelah status berubah menjadi `'Verified'`).
* `created_at` (TIMESTAMP)

---

## 📅 6. Jadwal Pelaksanaan Proyek (Timeline)

Sesuai ketentuan target pengerjaan manajemen proyek, estimasi pengerjaan terbagi ke dalam **8 Minggu**:

```
+------------------------------------------------------------------------+
| Waktu (Minggu) | Tahapan Kerja          | Target Luaran (Output)       |
+------------------------------------------------------------------------+
| Minggu 1 - 2   | Inisiasi & Analisis    | Dokumen SRS & Skema Database |
| Minggu 3 - 5   | Desain & Pengembangan  | Source Code Laravel & UI     |
| Minggu 6       | Pengujian (Testing)    | Laporan Uji Coba & Fix Bug   |
| Minggu 7 - 8   | Deployment & Final     | Live System & Manual Book    |
+------------------------------------------------------------------------+
```

---
*Dokumen komprehensif ini divalidasi oleh Hasnur selaku Project Manager untuk digunakan sebagai acuan baku pengembangan teknis oleh Developer.*
