<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$email = 'admin@example.com';
$user = \App\Models\User::where('email', $email)->first();
if (! $user) {
    echo "User with email $email not found.\n";
    exit(1);
}

$user->is_admin = true;
$user->save();

echo "User {$user->email} marked as admin (is_admin=1).\n";

