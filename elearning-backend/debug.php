<?php

try {
    require "vendor/autoload.php";
    $app = require "bootstrap/app.php";
    echo "Laravel loaded successfully\n";
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
    echo "File: " . $e->getFile() . "\n";
    echo "Line: " . $e->getLine() . "\n";
    echo "\nStack Trace:\n";
    echo $e->getTraceAsString();
}
