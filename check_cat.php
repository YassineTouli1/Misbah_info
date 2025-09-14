<?php
$controllerPath = 'app/Http/Controllers/Manager/CategoryController';
$files = glob($controllerPath . '/*.php');
foreach ($files as $file) {
    $content = file_get_contents($file);
    echo 'Checking: ' . basename($file) . PHP_EOL;

    if (preg_match('/DB::table\([\'"]category[\'"]\)/', $content, $matches)) {
        echo '  → PROBLEM: ' . $matches[0] . PHP_EOL;
    }
    if (preg_match('/from [\'"]category[\'"]/i', $content, $matches)) {
        echo '  → PROBLEM: ' . $matches[0] . PHP_EOL;
    }
    if (preg_match('/join [\'"]category[\'"]/i', $content, $matches)) {
        echo '  → PROBLEM: ' . $matches[0] . PHP_EOL;
    }
}
echo 'Search complete.' . PHP_EOL;
