<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['fuel_id'];
    $fuel_type = $_POST['fuel_type'];
    $fuel_quantity = $_POST['fuel_quantity'];
    $fuel_price = $_POST['fuel_price'];

    $sql = "UPDATE fuels SET fuel_type = '$fuel_type', fuel_quantity = '$fuel_quantity', fuel_price = '$fuel_price' WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header('Location: view_fuel.php?lang=' . $_GET['lang']);
    } else {
        echo "Error updating record: " . $conn->error;
    }
}
