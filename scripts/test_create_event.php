<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Event;

try {
    $e = Event::create([
        'title' => 'Teste fluxo',
        'date' => '2025-12-03',
        'city' => 'Local Teste',
        'private' => 0,
        'description' => 'Criado por script de teste',
        'items' => ['Cadeiras','Som'],
        'user_id' => 1,
    ]);
    echo "CREATED: id=" . $e->id . "\n";
} catch (Throwable $th) {
    echo "ERROR: " . $th->getMessage() . "\n";
}
