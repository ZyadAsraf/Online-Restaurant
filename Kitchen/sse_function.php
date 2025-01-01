<?php
function updateDatabaseAndNotifyClients() {
    $data = ['time' => date('Y-m-d H:i:s')];
    file_put_contents('updates.json', json_encode($data));
}