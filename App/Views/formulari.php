<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <div id="content">
        <div id="nav">
            <?php
            include 'head.php';
            ?>
        </div>
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-4">
                    <h2 class="text-center">Participació</h2>
                    <hr>
                    <form method="POST" action="/formulariPost" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="name">Nom</label>
                            <input type="text" class="form-control" id="name" name="name">
                        </div>
                        <div class="form-group">
                            <label for="surname">Cognom</label>
                            <input type="text" class="form-control" id="surname" name="surname">
                        </div>
                        <div class="form-group">
                            <label for="birthdate">Data de naixement</label>
                            <input type="date" class="form-control" id="birthdate" name="birthdate">
                        </div>
                        <div class="form-group">
                            <label for="address">Adreça</label>
                            <input type="text" class="form-control" id="address" name="address">
                        </div>
                        <div class="form-group">
                            <label for="number">Número</label>
                            <input type="text" class="form-control" id="number" name="number">
                        </div>
                        <div class="form-group">
                            <label for="city">Ciutat</label>
                            <input type="text" class="form-control" id="city" name="city">
                        </div>
                        <div class="form-group">
                            <label for="postalcode">Codi Postal</label>
                            <input type="text" class="form-control" id="postalcode" name="postalcode">
                        </div>
                        <div class="form-group">
                            <label for="group">Grup</label>
                            <input type="text" class="form-control" id="group" name="group">
                        </div>
                        <div class="form-group">
                            <label for="resguard">Resguard del pagament</label>
                            <input type="file" class="form-control-file" id="resguard" name="resguard">
                        </div>
                        <div class="text-center">
                            <button type="submit" class="button1">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>