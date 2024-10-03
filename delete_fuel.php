<?php
include 'db.php';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Load the appropriate language file
if ($lang === 'so') {
    include 'lang/somali.php';
} else {
    include 'lang/english.php';
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM fuels WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_fuel.php?lang=$lang");
        exit;
    } else {
        echo "Error deleting record: " . $conn->error;
    }
} else {
    header("Location: view_fuel.php?lang=$lang");
    exit;
}
