<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$checks = [
    'events' => function() { return \App\Models\Event::count(); },
    'sessions' => function() { return \App\Models\Session::count(); },
    'speakers' => function() { return \App\Models\Speaker::count(); },
    'session_speaker pivot' => function() { return \Illuminate\Support\Facades\DB::table('session_speaker')->count(); },
];

foreach ($checks as $label => $cb) {
    try {
        $count = $cb();
        echo $label . ': ' . $count . PHP_EOL;
    } catch (\Throwable $e) {
        echo $label . ': ERROR - ' . get_class($e) . ' - ' . $e->getMessage() . PHP_EOL;
    }
}

