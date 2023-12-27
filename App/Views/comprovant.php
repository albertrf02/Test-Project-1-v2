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
                <?= $lastInscription["id"] ?>
            </p>
            <p class="mb-2"><strong>Nom:</strong>
                <?= $lastInscription["nom"] ?>
            </p>
            <p class="mb-2"><strong>Cognoms:</strong>
                <?= $lastInscription["cognoms"] ?>
            </p>
            <p class="mb-2"><strong>Data de neixement:</strong>
                <?= $lastInscription["dataNaixement"] ?>
            </p>
            <p class="mb-2"><strong>Carrer:</strong>
                <?= $lastInscription["carrer"] ?>
            </p>
            <p class="mb-2"><strong>Numero:</strong>
                <?= $lastInscription["numero"] ?>
            </p>
            <p class="mb-2"><strong>Ciutat:</strong>
                <?= $lastInscription["ciutat"] ?>
            </p>
            <p class="mb-2"><strong>Codi postal:</strong>
                <?= $lastInscription["cp"] ?>
            </p>
            <p class="mb-2"><strong>Grup:</strong>
                <?= $lastInscription["grup"] ?>
            </p>

            <div class="flex mt-6">
                <a href="/"
                    class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition mr-6 ml-6">Pàgina
                    inicial</a>
                <a href="/login" class="bg-black text-white px-4 py-2 rounded-md hover:bg-gray-800 transition">Iniciar
                    sessió</a>
            </div>

        </div>
    </div>

</body>

</html>