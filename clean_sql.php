<?php
// Read and clean SQL file
$sqlFile = file_get_contents('database/opdracht5.sql');

// Remove DROP DATABASE, CREATE DATABASE, and USE statements
$sqlFile = preg_replace('/DROP DATABASE.*?;/is', '', $sqlFile);
$sqlFile = preg_replace('/CREATE DATABASE.*?;/is', '', $sqlFile);
$sqlFile = preg_replace('/USE\s+\w+\s*;/is', '', $sqlFile);

// Remove comments
$sqlFile = preg_replace('/(--.*?$|\/\*.*?\*\/)/ism', '', $sqlFile);

// Save cleaned file
file_put_contents('database/opdracht5_clean.sql', $sqlFile);

echo "Cleaned SQL file created.\n";
?>
