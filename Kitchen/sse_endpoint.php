<?php
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");

// Store client connections
// global $clients;

// Add this connection to the list of clients
// $clientId = uniqid();
// $clients[$clientId] = fopen('php://output', 'w');

$lastUpdate = isset($_SERVER['HTTP_LAST_EVENT_ID']) ? intval($_SERVER['HTTP_LAST_EVENT_ID']) : 0;

clearstatcache();
$currentModTime = filemtime('../updates.json');

if ($currentModTime > $lastUpdate) {
    echo "refresh\n\n";
    flush();
}
exit();
?>