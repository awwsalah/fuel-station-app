<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fuel Station Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        .container {
            text-align: center;
            margin-top: 150px;
        }

        .btn-language {
            padding: 20px 40px;
            font-size: 20px;
            margin: 10px;
        }
    </style>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto">
        <h1 class="text-3xl font-bold">Choose Your Language</h1>
        <p class="mt-2">Select the language for the interface</p>
        <br>
        <h4 class="mb-3 text-xl">Dooro Luqada aad uu isticmaalaysid nidaamka</h4>
        <div class="language-buttons mt-4">
            <!-- Language buttons -->
            <a href="home.php?lang=en" class="btn-language bg-blue-500 text-white rounded-lg">English</a>
            <a href="home.php?lang=so" class="btn-language bg-gray-500 text-white rounded-lg">Somali</a>
        </div>
    </div>
</body>

</html>