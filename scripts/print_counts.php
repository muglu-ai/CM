<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo 'events: ' . \App\Models\Event::count() . PHP_EOL;
echo 'sessions: ' . \App\Models\Session::count() . PHP_EOL;
echo 'speakers: ' . \App\Models\Speaker::count() . PHP_EOL;
echo 'session_speaker pivot: ' . \Illuminate\Support\Facades\DB::table('session_speaker')->count() . PHP_EOL;

