<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprovant</title>
    <!-- Add the Tailwind CSS CDN link -->
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
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
                <?= $lastInscription["Id"] ?>
            </p>
            <p class="mb-2"><strong>Nom:</strong>
                <?= $lastInscription["Nom"] ?>
            </p>
            <p class="mb-2"><strong>Cognoms:</strong>
                <?= $lastInscription["Cognoms"] ?>
            </p>
            <p class="mb-2"><strong>Data de neixement:</strong>
                <?= $lastInscription["DataNaixement"] ?>
            </p>
            <p class="mb-2"><strong>Carrer:</strong>
                <?= $lastInscription["Carrer"] ?>
            </p>
            <p class="mb-2"><strong>Numero:</strong>
                <?= $lastInscription["Numero"] ?>
            </p>
            <p class="mb-2"><strong>Ciutat:</strong>
                <?= $lastInscription["Ciutat"] ?>
            </p>
            <p class="mb-2"><strong>Codi postal:</strong>
                <?= $lastInscription["CP"] ?>
            </p>
            <p class="mb-2"><strong>Grup:</strong>
                <?= $lastInscription["Grup"] ?>
            </p>

            <div class="mt-6 text-center">
                <a href="/" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">Torna a
                    la pàgina inicial</a>
            </div>
        </div>
    </div>

</body>

</html>