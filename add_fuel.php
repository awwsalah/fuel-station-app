<?php
// Include the database and check for the selected language
include 'db.php';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Load the appropriate language file
if ($lang === 'so') {
    include 'lang/somali.php';
} else {
    include 'lang/english.php';
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fuel_type = $_POST['fuel_type'];
    $fuel_quantity = $_POST['fuel_quantity'];
    $fuel_price = $_POST['fuel_price'];

    $sql = "INSERT INTO fuels (fuel_type, fuel_quantity, fuel_price) 
            VALUES ('$fuel_type', '$fuel_quantity', '$fuel_price')";

    if ($conn->query($sql) === TRUE) {
        header("Location: view_fuel.php?lang=$lang");
        exit;
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang_strings['title']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
</head>

<body class="bg-light">
    <div class="container mt-5">
        <h1 class="text-center"><?php echo $lang_strings['add_fuel']; ?></h1>
        <div class="col-md-6 offset-md-3">
            <form action="" method="POST" class="form-control p-4">
                <div class="mb-3">
                    <label for="fuel_type" class="form-label">Fuel Type</label>
                    <input type="text" class="form-control" id="fuel_type" name="fuel_type" required>
                </div>
                <div class="mb-3">
                    <label for="fuel_quantity" class="form-label">Fuel Quantity (Liters)</label>
                    <input type="number" step="0.01" class="form-control" id="fuel_quantity" name="fuel_quantity" required>
                </div>
                <div class="mb-3">
                    <label for="fuel_price" class="form-label">Fuel Price (USD)</label>
                    <input type="number" step="0.01" class="form-control" id="fuel_price" name="fuel_price" required>
                </div>
                <button type="submit" class="btn btn-primary"><?php echo $lang_strings['add_fuel']; ?></button>
                <a href="view_fuel.php?lang=<?php echo $lang; ?>" class="btn btn-secondary">Back</a>
            </form>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>