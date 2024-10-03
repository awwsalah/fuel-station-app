<?php
$servername = "127.0.0.1";  // Use 127.0.0.1 to force TCP/IP connection
$username = "root";
$password = "";  // Your MySQL password (if any)
$dbname = "fuel_station";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
