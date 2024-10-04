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
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-5">
        <h1 class="text-center text-3xl font-bold"><?php echo $lang_strings['title']; ?></h1>
        <div class="text-center mt-4">
            <a href="add_fuel.php?lang=<?php echo $lang; ?>" class="btn btn-primary mt-4 bg-blue-500 text-white py-2 px-4 rounded"><?php echo $lang_strings['add_fuel']; ?></a>
            <a href="view_fuel.php?lang=<?php echo $lang; ?>" class="btn btn-success mt-4 bg-green-500 text-white py-2 px-4 rounded"><?php echo $lang_strings['view_fuel']; ?></a>
        </div>
    </div>
</body>

</html>