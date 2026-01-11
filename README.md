# 🎓 EduPoint LMS

Sistem Manajemen Pembelajaran (Learning Management System) berbasis web yang dibangun menggunakan Laravel 10, Livewire, dan Tailwind CSS.

## 📋 Daftar Isi

-   [Tentang Proyek](#tentang-proyek)
-   [Fitur Utama](#fitur-utama)
-   [Teknologi yang Digunakan](#teknologi-yang-digunakan)
-   [Persyaratan Sistem](#persyaratan-sistem)
-   [Instalasi](#instalasi)
-   [Konfigurasi](#konfigurasi)
-   [Menjalankan Aplikasi](#menjalankan-aplikasi)
-   [Struktur Proyek](#struktur-proyek)
-   [Testing](#testing)
-   [Kontribusi](#kontribusi)

## 🎯 Tentang Proyek

EduPoint LMS adalah platform pembelajaran online yang memungkinkan instruktur untuk membuat dan mengelola kursus, serta memungkinkan siswa untuk mendaftar dan mengikuti kursus dengan sistem pembayaran terintegrasi.

## ✨ Fitur Utama

### Untuk Siswa:

-   📚 **Pencarian dan Browsing Kursus** - Melihat katalog kursus yang tersedia
-   💳 **Sistem Pembayaran** - Mendaftar kursus dengan metode pembayaran yang fleksibel
-   📧 **Notifikasi Email** - Menerima pemberitahuan saat berhasil mendaftar kursus
-   💬 **Sistem Pesan** - Berkomunikasi dengan instruktur dan siswa lain
-   🔔 **Real-time Notifications** - Notifikasi langsung untuk update penting

### Untuk Admin/Instruktur:

-   ➕ **Manajemen Kursus** - Membuat, mengedit, dan menghapus kursus
-   👥 **Manajemen Enrollment** - Melihat dan mengelola pendaftaran siswa
-   📊 **Dashboard Admin** - Melihat statistik dan informasi penting
-   📬 **Notifikasi Otomatis** - Menerima pemberitahuan saat ada siswa baru mendaftar

### Fitur Teknis:

-   🔐 **Autentikasi & Otorisasi** - Sistem login yang aman dengan role-based access control
-   🎨 **Real-time UI** - Interface yang responsif menggunakan Livewire
-   🔄 **Event-Driven Architecture** - Sistem event dan listener untuk proses yang efisien
-   💾 **Repository Pattern** - Kode yang terstruktur dan mudah di-maintain
-   🏭 **Factory Pattern** - Implementasi payment gateway yang fleksibel

## 🛠️ Teknologi yang Digunakan

### Backend:

-   **Laravel 10** - PHP Framework untuk web aplikasi
-   **PHP 8.1+** - Bahasa pemrograman server-side
-   **MySQL** - Database relasional
-   **Laravel Sanctum** - API authentication
-   **Laravel Breeze** - Authentication scaffolding

### Frontend:

-   **Livewire 3** - Framework untuk membuat interface reaktif tanpa JavaScript kompleks
-   **Volt** - Livewire single-file components
-   **Alpine.js** - JavaScript framework minimal untuk interaksi UI
-   **Tailwind CSS** - Utility-first CSS framework
-   **Vite** - Frontend build tool yang cepat

### Development & Testing:

-   **Pest PHP** - Testing framework modern untuk PHP
-   **Laravel Pint** - Code style fixer
-   **Faker** - Library untuk generate data dummy

## 💻 Persyaratan Sistem

Pastikan sistem Anda memenuhi persyaratan berikut:

-   PHP >= 8.1
-   Composer
-   Node.js >= 18.x dan NPM
-   MySQL >= 5.7 atau MariaDB >= 10.3
-   Git

### Extension PHP yang Diperlukan:

-   BCMath
-   Ctype
-   cURL
-   DOM
-   Fileinfo
-   JSON
-   Mbstring
-   OpenSSL
-   PCRE
-   PDO
-   Tokenizer
-   XML

## 📥 Instalasi

### 1. Clone Repository

```bash
git clone <repository-url>
cd edupoint-lms
```

### 2. Install Dependencies

```bash
# Install PHP dependencies
composer install

# Install JavaScript dependencies
npm install
```

### 3. Konfigurasi Environment

```bash
# Copy file environment
cp .env.example .env

# Generate application key
php artisan key:generate
```

### 4. Konfigurasi Database

Edit file `.env` dan sesuaikan dengan konfigurasi database Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=edupoint_lms
DB_USERNAME=root
DB_PASSWORD=
```

### 5. Jalankan Migration

```bash
# Jalankan migration untuk membuat tabel database
php artisan migrate

# (Opsional) Jalankan seeder untuk data dummy
php artisan db:seed
```

## ⚙️ Konfigurasi

### Konfigurasi Mail

Edit konfigurasi email di file `.env`:

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@edupoint.com
MAIL_FROM_NAME="${APP_NAME}"
```

### Konfigurasi Queue

Untuk menjalankan job dan notifikasi secara asynchronous:

```env
QUEUE_CONNECTION=database
```

### Konfigurasi Broadcasting (Opsional)

Jika ingin menggunakan real-time features:

```env
BROADCAST_DRIVER=log
```

## 🚀 Menjalankan Aplikasi

### Development Mode

Buka 3 terminal dan jalankan perintah berikut:

**Terminal 1 - Laravel Development Server:**

```bash
php artisan serve
```

**Terminal 2 - Vite Development Server (untuk asset):**

```bash
npm run dev
```

**Terminal 3 - Queue Worker (untuk background jobs):**

```bash
php artisan queue:work
```

Aplikasi akan berjalan di: `http://localhost:8000`

### Production Build

```bash
# Build assets untuk production
npm run build

# Optimasi aplikasi
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📁 Struktur Proyek

```
edupoint-lms/
├── app/
│   ├── Events/              # Event classes (UserEnrolled, dll)
│   ├── Listeners/           # Event listeners (NotifyInstructor, dll)
│   ├── Livewire/            # Livewire components
│   │   ├── Admin/           # Admin components (Course, Enrollment management)
│   │   ├── CourseIndex.php  # Halaman daftar kursus
│   │   ├── CourseShow.php   # Halaman detail kursus
│   │   └── MessageIndex.php # Halaman pesan
│   ├── Models/              # Eloquent models (User, Course, Enrollment)
│   ├── Repositories/        # Repository pattern implementation
│   ├── Services/            # Business logic services
│   ├── Factories/           # Factory pattern (PaymentFactory)
│   └── Notifications/       # Notification classes
├── database/
│   ├── migrations/          # Database migrations
│   ├── seeders/             # Database seeders
│   └── factories/           # Model factories untuk testing
├── resources/
│   ├── views/               # Blade templates
│   ├── css/                 # Stylesheet files
│   └── js/                  # JavaScript files
├── routes/
│   ├── web.php              # Web routes
│   ├── api.php              # API routes
│   └── channels.php         # Broadcasting channels
├── tests/
│   ├── Feature/             # Feature tests
│   └── Unit/                # Unit tests
└── public/                  # Public assets
```

## 🧪 Testing

Proyek ini menggunakan Pest PHP untuk testing:

```bash
# Jalankan semua test
php artisan test

# atau dengan Pest
./vendor/bin/pest

# Jalankan test spesifik
./vendor/bin/pest --filter=EnrollmentTest

# Jalankan dengan coverage
./vendor/bin/pest --coverage
```

## 👥 Role & Permission

### User Roles:

-   **Admin**: Akses penuh ke semua fitur termasuk manajemen kursus dan enrollment
-   **Student**: Dapat browsing kursus, mendaftar, dan mengakses kursus yang sudah dibeli

### Middleware:

-   `auth`: Memastikan user sudah login
-   `verified`: Memastikan email sudah diverifikasi
-   `admin`: Memastikan user memiliki role admin

## 🔄 Arsitektur & Design Patterns

### Repository Pattern

Memisahkan logic database dari business logic:

-   `CourseRepository` & `CourseRepositoryInterface`
-   `EnrollmentRepository` & `EnrollmentRepositoryInterface`
-   `UserRepository` & `UserRepositoryInterface`

### Factory Pattern

Implementasi payment gateway yang fleksibel:

-   `PaymentFactory` untuk membuat instance payment gateway
-   `PaymentGatewayInterface` untuk contract

### Service Layer

Business logic terpisah dari controller:

-   `EnrollmentService` - Handle enrollment process
-   `CourseService` - Handle course management

### Event-Driven

Menggunakan Events dan Listeners:

-   Event: `UserEnrolled`
-   Listeners: `NotifyInstructor`, `NotifyUserOfEnrollment`

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan ikuti langkah berikut:

1. Fork repository ini
2. Buat branch untuk fitur baru (`git checkout -b feature/AmazingFeature`)
3. Commit perubahan Anda (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

### Coding Standards

-   Ikuti PSR-12 coding standard untuk PHP
-   Gunakan Laravel Pint untuk format code: `./vendor/bin/pint`
-   Tulis test untuk fitur baru
-   Update dokumentasi jika diperlukan

## 🙏 Acknowledgments

-   Laravel Framework
-   Livewire
-   Tailwind CSS
-   Semua contributor yang telah membantu proyek ini

## 📞 Kontak & Support

Jika Anda memiliki pertanyaan atau membutuhkan bantuan:

-   Buat issue di repository ini
-   Email: [email-anda@example.com]

---

**Dibuat dengan menggunakan Laravel & Livewire**
