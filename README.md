 🌙 Lathifa Tour – Travel Haji & Umroh  
Aplikasi Website Travel Haji dan Umroh Berbasis Laravel 12 & Livewire

 📝 Deskripsi Singkat
Lathifa Tour adalah aplikasi web yang dirancang untuk memudahkan jamaah dalam mencari, membandingkan, dan mendaftar paket Haji dan Umroh. Sistem ini juga membantu admin dalam mengelola data paket, inquiry, testimoni, dan proses bisnis lainnya secara lebih cepat, aman, dan terstruktur. Dengan tampilan modern dan fitur lengkap, aplikasi ini mendukung pelayanan travel agar lebih profesional dan efisien.

✨ Fitur Utama
- **Form Inquiry (Lead Generation)**  
  Jamaah dapat mengirimkan pertanyaan atau minat paket, dengan notifikasi otomatis ke admin.
- **Galeri Foto & Video Perjalanan**  
  Menampilkan dokumentasi perjalanan untuk meningkatkan kepercayaan jamaah.
- **Blog Artikel & Panduan Ibadah**  
  Admin dapat memposting artikel seputar manasik, tips perjalanan, dan update terbaru.
- **Filter Paket (Tanggal, Harga, Durasi)**  
  Memudahkan jamaah menemukan paket sesuai kebutuhan.
- **Pencarian Paket**  
  Fitur search cepat berdasarkan nama paket atau kategori.
- **Tampilan Itinerary Detail per Hari**  
  Setiap paket memiliki detail kegiatan harian yang jelas.
- **Halaman Testimoni Jamaah (User-facing)**  
  Menampilkan ulasan yang meningkatkan kredibilitas travel.
- **Ekspor Daftar Pendaftaran (Admin)**  
  Admin dapat mengekspor data ke Excel untuk laporan.
- **Sistem Notifikasi (WA/Email setelah Inquiry)**  
  Inquiry langsung terkirim ke admin dan jamaah sebagai konfirmasi.
- **Halaman FAQ Interaktif**  
  Menjawab pertanyaan umum secara cepat dan sederhana.

 🛠 Teknologi yang Digunakan
- **Laravel 12** – Framework utama backend  
- **Livewire** – Komponen interaktif tanpa perlu JavaScript berat  
- **TailwindCSS** – Styling modern dan responsif  
- **MySQL** – Sistem database  
- **Spatie Permissions (opsional)** – Manajemen role & permission  
- **Laravel Excel (opsional)** – Ekspor data pendaftaran  
- **API WhatsApp / Mail** – Notifikasi inquiry  

 ⚙ Cara Instalasi
Pastikan sudah terinstall:
- PHP 8.2+
- Composer
- MySQL
- Node.js & NPM

1. Clone Repository
bash
git clone [https://github.com/username/lathifa-tour.git](https://github.com/somalaayuaisya-ai/project-lathifa-tour.git  )
cd lathifa-tour
`

2. Install Dependencies

bash
composer install
npm install

3. Copy File Environment

bash
cp .env.example .env

4. Generate App Key

bash
php artisan key:generate

5. Konfigurasi Database

Edit `.env`:

DB_DATABASE=lathifatour
DB_USERNAME=root
DB_PASSWORD=

6. Migrasi Database

bash
php artisan migrate --seed

7. Compile Frontend

bash
npm run build

▶ Cara Menjalankan Project

Jalankan server Laravel:

bash
php artisan serve

Jika menggunakan Vite untuk pengembangan:

bash
npm run dev

Akses melalui:

http://localhost:8000
