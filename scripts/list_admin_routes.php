<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

/** @var \Illuminate\Routing\RouteCollection $routes */
$routes = app('router')->getRoutes();
$found = [];

foreach ($routes as $route) {
    $name = $route->getName();
    if (! $name) continue;
    if (str_starts_with($name, 'admin.')) {
        $found[] = [
            'name' => $name,
            'methods' => implode(',', $route->methods()),
            'uri' => $route->uri(),
            'middleware' => implode(',', $route->gatherMiddleware()),
        ];
    }
}

if (!count($found)) {
    echo "No admin.* routes found.\n";
    exit(0);
}

foreach ($found as $r) {
    echo sprintf("%-40s %-12s %-40s %s\n", $r['name'], $r['methods'], $r['uri'], $r['middleware']);
}

