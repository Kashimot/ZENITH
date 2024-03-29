<?php
$searchQuery = $_GET['searchQuery'];
$targetDir = "uploads/";

// Perform folder search
$folders = glob($targetDir . $searchQuery . '/*', GLOB_ONLYDIR);
foreach ($folders as $folder) {
    echo basename($folder) . "<br>";
}
?>
