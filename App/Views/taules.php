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
                <th>Carta</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($userCards as $card): ?>
                <tr>
                    <td>
                        <?= $card['id']; ?>
                    </td>
                    <td>
                        <span class="text-blue-500 cursor-pointer hover:underline image-link"
                            data-path="<?= "/resguard/" . $card['path']; ?>">
                            <?= $card['path']; ?>
                        </span>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <hr class="mt-4">

    <div class="text-center mt-4">
        <a href="#" onclick="showUploadModal()"
            class="inline-block bg-black text-white py-2 px-4 rounded hover:bg-gray-600">
            Pujar carta
        </a>
    </div>

    <div id="imageModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white p-4">
                    <img id="modalImage" src="" alt="ImageView" class="w-full">
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring focus:border-indigo-500 sm:ml-3 sm:w-auto sm:text-sm"
                        onclick="hideModal()">
                        Tencar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="uploadModal" class="fixed inset-0 overflow-y-auto hidden">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity" aria-hidden="true">
                <div class="absolute inset-0 bg-gray-500 opacity-75"></div>
            </div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div
                class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form id="uploadForm" action="/uploadCard" method="POST" enctype="multipart/form-data"
                    class="bg-white p-4">
                    <input type="file" name="card" id="card" class="mb-4" aria-label="imageForm">
                    <input type="submit" value="Pujar"
                        class="bg-green-500 text-white py-2 px-4 rounded hover:bg-green-600">
                </form>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <button type="button" onclick="hideUploadModal()"
                        class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring focus:border-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                        Tencar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <?php require "scripts.php" ?>
</body>

</html>