<?php

use Illuminate\Support\Facades\Schedule;

// Geser tanggal tagihan yang sudah lewat, setiap hari lewat tengah malam (WIB).
Schedule::command('subscriptions:advance-dates')->dailyAt('00:05');