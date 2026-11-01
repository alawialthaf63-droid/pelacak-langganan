# Pelacak Langganan

Aplikasi web untuk mencatat langganan (Netflix, Spotify, domain, hosting, dll), menghitung total pengeluaran per bulan, dan mengingatkan tagihan yang segera jatuh tempo.

## Fitur

- Tambah, ubah, dan hapus langganan
- Total pengeluaran per bulan (langganan tahunan otomatis dibagi 12)
- Peringatan tagihan yang jatuh tempo dalam 7 hari ke depan
- Tanggal tagihan maju otomatis ke periode berikutnya setelah lewat, dijalankan harian lewat Laravel Scheduler

## Teknologi

Laravel 13, PHP 8.4+, SQLite, Blade

## Cara menjalankan

```
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

Buka `http://127.0.0.1:8000`.

## Logika utama

- `app/Models/Subscription.php`: perhitungan biaya bulanan dan fungsi `advanceBillingDate()`
- `app/Console/Commands/AdvanceBillingDates.php`: perintah `subscriptions:advance-dates`
- `routes/console.php`: jadwal harian perintah di atas