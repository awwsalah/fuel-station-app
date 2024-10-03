<?php
// Check if the language is set in the URL
$lang = isset($_GET['lang']) ? $_GET['lang'] : 'en';

// Load the appropriate language file
if ($lang === 'so') {
    include 'lang/somali.php';
} else {
    include 'lang/english.php';
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
        <h1 class="text-center"><?php echo $lang_strings['title']; ?></h1>
        <div class="text-center ">
            <a href="add_fuel.php?lang=<?php echo $lang; ?>" class="btn btn-primary mt-4"><?php echo $lang_strings['add_fuel']; ?></a>
            <a href="view_fuel.php?lang=<?php echo $lang; ?>" class="btn btn-success mt-4"><?php echo $lang_strings['view_fuel']; ?></a>
        </div>
    </div>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
</body>

</html>