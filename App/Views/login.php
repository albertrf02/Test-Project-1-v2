<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="/main.css">
    <title>Login</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full p-6 bg-white rounded-md shadow-md border">
        <img src="/img/logo.jpg" alt="Logo" class="w-16 h-16 mx-auto mb-4">
        <form id="loginAJAX" method="post" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-600">Introdueix el teu token</label>
                <input type="text" name="username" id="username" class="mt-1 p-2 w-full border rounded-md">
            </div>
            <div>
                <input type="submit" value="Login" class="bg-blue-500 text-white p-2 rounded-md cursor-pointer w-full">
            </div>
        </form>
    </div>
</body>
<?php require "scripts.php" ?>

</html>