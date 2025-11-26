<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Event;

$e = Event::latest()->first();
if ($e) {
    echo "id={$e->id}\n";
    echo "title={$e->title}\n";
    echo "items=" . json_encode($e->items) . "\n";
} else {
    echo "No event found\n";
}
