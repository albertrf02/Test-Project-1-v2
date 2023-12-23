<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovant</title>
</head>

<body>
    <h1>Comprovant</h1>
    <p>El teu registre s'ha realitzat correctament, aquestes son les dades que has introduit:</p>

    <?php if (isset($user) && !empty($user)): ?>
        <ul>
            <li>Nom:
                <?= $user['Nom'] ?>
            </li>
            <li>Cognoms:
                <?= $user['Cognoms'] ?>
            </li>
            <!-- Add other fields as needed -->
        </ul>
    <?php endif; ?>
</body>

</html>