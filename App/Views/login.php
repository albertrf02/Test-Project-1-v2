<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form id="loginAJAX" method="post">
        <label for="username">Username</label>
        <input type="text" name="username" id="username">
        <input type="submit" value="Login">
    </form>
    <?= var_dump($user) ?>
</body>
<?php require "scripts.php" ?>

</html>