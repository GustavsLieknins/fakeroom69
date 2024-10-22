<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();


Artisan::command('balls', function () {
    $this->comment("Birb with big balls");
})->purpose('Display an inspiring quote')->hourly();
