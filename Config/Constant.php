<?php

// Start Session
session_start();

//Constants to Store Non Repeating Values
define('HOMEURL', 'http://localhost/Online-Restaurant/');
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'online_restaurant');


// Execute the Query and Save Data in Database
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD) or die(mysqli_error($conn)); // Database Connection
$db_select = mysqli_select_db($conn, DB_NAME) or die(mysqli_error($conn)); // Selecting Database
?>