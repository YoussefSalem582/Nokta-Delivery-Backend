<?php

$modelsDir = __DIR__ . '/app/Models';
$files = glob($modelsDir . '/*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Skip if HasUuids is already present
    if (strpos($content, 'HasUuids') !== false) continue;
    
    // Insert HasUuids namespace
    $content = preg_replace(
        '/namespace App\\\\Models;/',
        "namespace App\\Models;\n\nuse Illuminate\\Database\\Eloquent\\Concerns\\HasUuids;",
        $content
    );
    
    // Insert HasUuids trait and guarded property
    $content = preg_replace(
        '/\{/',
        "{\n    use HasUuids;\n\n    protected \$guarded = [];\n",
        $content,
        1
    );
    
    file_put_contents($file, $content);
    echo "Updated model: " . basename($file) . "\n";
}
