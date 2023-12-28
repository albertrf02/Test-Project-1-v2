<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Taules</title>
</head>
<?php require "header.php" ?>

<body>
    <table id="userCards" class="display">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userCards as $card): ?>
                <tr>
                    <td>
                        <?= $card['id']; ?>
                    </td>
                    <td>
                        <?= $card['path']; ?>
                    </td>
                    <td>
                        <?= $card['idParticipants']; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <?php require "scripts.php" ?>
</body>

</html>