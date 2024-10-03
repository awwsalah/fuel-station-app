<?php
include 'db.php';
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Load the appropriate language file
if ($lang === 'so') {
    include 'lang/somali.php';
} else {
    include 'lang/english.php';
}

// Check if the ID is passed and is valid
if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer

    // Fetch the fuel data based on the transaction ID
    $sql = "SELECT * FROM fuels WHERE id = $id";
    $result = $conn->query($sql);

    // Check if the query returned any result
    if ($result->num_rows > 0) {
        $fuel = $result->fetch_assoc();
        // Calculate total for the transaction (quantity * price)
        $total_for_row = $fuel['fuel_quantity'] * $fuel['fuel_price'];
    } else {
        echo "<div class='alert alert-danger text-center'>No record found with the given ID.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-danger text-center'>No ID provided. Redirecting to fuel list...</div>";
    header("Refresh:2; url=view_fuel.php?lang=$lang"); // Redirect after 2 seconds
    exit;
}
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $lang_strings['invoice']; ?></title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <style>
        .invoice-container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-header h1 {
            margin-bottom: 10px;
        }

        .invoice-details {
            margin-bottom: 30px;
        }

        .invoice-footer {
            text-align: center;
            margin-top: 20px;
        }

        .invoice-details strong {
            width: 150px;
            display: inline-block;
        }
    </style>
</head>

<body class="bg-light">
    <div class="invoice-container">
        <div class="invoice-header">
            <h1><?php echo $lang_strings['invoice']; ?></h1>
            <p><?php echo $lang_strings['fuel_station']; ?></p>
        </div>

        <div class="invoice-details">
            <p><strong><?php echo $lang_strings['fuel_type']; ?>:</strong> <?php echo $fuel['fuel_type']; ?></p>
            <p><strong><?php echo $lang_strings['quantity']; ?>:</strong> <?php echo $fuel['fuel_quantity']; ?> Liters</p>
            <p><strong><?php echo $lang_strings['price']; ?> (USD):</strong> $<?php echo $fuel['fuel_price']; ?></p>
            <p><strong><?php echo $lang_strings['total']; ?> (USD):</strong> $<?php echo $total_for_row; ?></p>
            <p><strong><?php echo $lang_strings['date_added']; ?>:</strong> <?php echo $fuel['date_added']; ?></p>
        </div>

        <div class="invoice-footer">
            <button class="btn btn-primary" onclick="window.print()"><?php echo $lang_strings['print_invoice']; ?></button>
            <a href="view_fuel.php?lang=<?= $lang ?>" class="btn btn-secondary"><?php echo $lang_strings['back']; ?></a>
        </div>
    </div>

    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>