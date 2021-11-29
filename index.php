<?php
    
    $now = new DateTime("now", new DateTimeZone("Europe/Paris"));

?>
<!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link rel="stylesheet" href="assets/css/style.css">

        <title>DonkeyAir</title>
    </head>
    <body>
        <main class="container-fluid bg-image">
            <div class="row justify-content-center">
                <div class="col-10 card p-5 m-5 rounded-3">
                    <h2>Rechercher des vols</h2>
                    <?php include("templates/form-search.php");?>
                </div>
            </div>
        </main>
    <script src="assets/js/main.js"></script>
    </body>
</html>