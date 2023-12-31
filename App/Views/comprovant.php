<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/main.css">
    <title>Comprovant</title>
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="bg-white p-8 rounded-lg shadow-md w-full sm:w-96">
        <h1 class="text-3xl font-bold mb-6 text-center">Comprovant</h1>
        <p class="text-center">El teu registre s'ha realitzat correctament, aquestes són les dades que has introduït:
        </p>

        <div class="mt-8">
            <h2 class="text-2xl font-bold mb-4">Informació registrada</h2>
            <hr class="mb-4">
            <p class="mb-2"><strong>Codi de registre:</strong>
                <a href="<?= $urltoken ?>">
                    <?= $participant["token"] ?>
                </a>
            </p>
            <p class="mb-2"><strong>Nom:</strong>
                <?= $participant["nom"] ?>
            </p>
            <p class="mb-2"><strong>Cognoms:</strong>
                <?= $participant["cognoms"] ?>
            </p>
            <p class="mb-2"><strong>Data de neixement:</strong>
                <?= $participant["dataNaixement"] ?>
            </p>
            <p class="mb-2"><strong>Carrer:</strong>
                <?= $participant["carrer"] ?>
            </p>
            <p class="mb-2"><strong>Numero:</strong>
                <?= $participant["numero"] ?>
            </p>
            <p class="mb-2"><strong>Ciutat:</strong>
                <?= $participant["ciutat"] ?>
            </p>
            <p class="mb-2"><strong>Codi postal:</strong>
                <?= $participant["cp"] ?>
            </p>
            <p class="mb-2"><strong>Grup:</strong>
                <?= $participant["grup"] ?>
            </p>

            <img src="<?= "/qr/" . $qrfilename; ?>" alt="" class="ml-20">


            <div class="flex mt-6 mb-6">
                <a href="/"
                    class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition mr-6 ml-6">Pàgina
                    inicial</a>
                <a href="/login" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">Iniciar
                    sessió</a>
            </div>

            <hr class="mb-2">
            <p>
                <strong>IMPORTANT: </strong>Guarda el codi de registre per poder iniciar sessió.
            </p>

        </div>
    </div>
</body>
<?php require "scripts.php" ?>

</html>