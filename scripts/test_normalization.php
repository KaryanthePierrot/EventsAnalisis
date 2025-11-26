<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Event;

echo "=== Testing Normalization and Validation ===\n\n";

// Test 1: Create event with duplicate items (different cases)
echo "Test 1: Create event with duplicate items (case-insensitive)\n";
try {
    $e1 = Event::create([
        'title' => 'Event with Normalization',
        'date' => '2025-12-10',
        'city' => 'São Paulo',
        'private' => 0,
        'description' => 'Testing item normalization',
        'items' => ['Cadeiras', 'som', 'CADEIRAS', '  Som  '],
        'user_id' => 1,
    ]);
    echo "✓ Event ID " . $e1->id . " created\n";
    echo "  Items stored: " . json_encode($e1->items) . "\n";
    
    // Verify normalization happened
    if (count($e1->items) === 2) {
        echo "  ✓ Duplicates removed correctly\n";
    } else {
        echo "  ✗ Expected 2 unique items, got " . count($e1->items) . "\n";
    }
} catch (Throwable $th) {
    echo "✗ Error: " . $th->getMessage() . "\n";
}

echo "\n";

// Test 2: Validation - missing required field
echo "Test 2: Validation - attempting to create event without title\n";
try {
    $e2 = Event::create([
        'title' => '',  // Empty title (should be caught by validation in controller)
        'date' => '2025-12-11',
        'city' => 'Rio',
        'private' => 1,
        'description' => 'No title event',
        'items' => [],
        'user_id' => 1,
    ]);
    echo "✗ Event created without validation (unexpected)\n";
} catch (Throwable $th) {
    echo "✓ Validation would catch this: " . substr($th->getMessage(), 0, 50) . "...\n";
}

echo "\n";

// Test 3: Read last event and verify structure
echo "Test 3: Read last event and verify items array\n";
$last = Event::latest()->first();
if ($last) {
    echo "✓ Last event: ID=" . $last->id . ", Title=" . $last->title . "\n";
    echo "  Items type: " . gettype($last->items) . "\n";
    echo "  Items value: " . json_encode($last->items) . "\n";
    
    if (is_array($last->items)) {
        echo "  ✓ Items is correctly cast to array\n";
    }
} else {
    echo "✗ No events found\n";
}

echo "\n=== Tests Complete ===\n";
