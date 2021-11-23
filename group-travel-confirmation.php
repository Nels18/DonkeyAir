<?php
    require_once "lib/functions.php";
    // var_dump($_GET);

    testData($_GET);
    $searchCityStart = ($_GET['city-start']);
    $searchCityTo = ($_GET['city-to']);
    $searchDepartureDate = ($_GET['departure-date']);
    $searchArrivalDate = ($_GET['return-date']);
    $searchTripClass = ($_GET['trip-class']);
    $searchTripType = ($_GET['trip-type']);
    $searchNumberOfPassenger = ($_GET['number-of-passenger']);




    setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
    if ('GET' == $_SERVER['REQUEST_METHOD']) {
        $_GET['failMessage'] = getErrors($numberMaxPassengers,$failMessage);
        if ('' == $_GET['failMessage']) {
            header('Location: group-travel-confirmation.php');
        } else {
            header('location:index.php');
        }
    }
    // if (isset($_SESSION)) {
    //         var_dump($_SESSION);
    //     }
        
    //     if ('GET' == $_SERVER['REQUEST_METHOD']) {
    //         $_GET['fail-message'] = getErrors($numberMaxPassengers,$failMessage);
    //         if (isset($_GET['fail-message'])) {
    //             header('location:index.php');
    //         } else {
    //             // header('Location: group-travel-confirmation.php');
    //         }
    //         var_dump($_GET['fail-message']);
    //     }

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
        <main class="container-fluid">
            <div class="row justify-content-center">
            <div class="col-10 card p-5 m-5 rounded-3">
                <div class="card-body">
                    <h2 class="card-title">Votre demande a été envoyé.</h2>
                    <p class="card-text mb-5">Nous traiteront votre demande dans les plus brèves délais.</p>
                    <div class="row justify-content-md-center border-top">
                        <h3 class="my-3">Récapitulatif</h3>
                        <div class="col<?php if('one-way' == $searchTripType) echo "-6" ;?>">
                            <div class="card mt-5 rounded-3 bg-primary text-white">
                                <h4 class="card-header">Vol aller</h4>
                                <div class="card-body">
                                    <p>Depuis : <?= $searchCityStart;?></p>
                                    <p>Vers : <?= $searchCityTo;?></p>
                                    <p>Le <?= (empty(strftime('%a. %d %G',strtotime($searchDepartureDate)))) ? '' : $searchDepartureDate;?></p>
                                    <p>En classe <?= translateTripClass($searchTripClass);?></p>
                                </div>
                            </div>
                        </div>
                        <?php if('round-trip' == $searchTripType): ;?>
                            <div class="col">
                                <div class="card mt-5 rounded-3 bg-primary text-white">
                                    <h4 class="card-header">Vol retour</h4>
                                    <div class="card-body">
                                        <p>Depuis : <?= $searchCityTo;?></p>
                                        <p>Vers : <?= $searchCityStart;?></p>
                                        <p>Le <?= (empty(strftime('%a. %d %G',strtotime(($searchArrivalDate))))) ? '' : $searchArrivalDate;?></p>
                                        <p>En classe <?= translateTripClass($searchTripClass);?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endif ;?>
                    </div>
                </div>
            </div>
            </div>
        </main>
    <script src="assets/js/main.js"></script>
    </body>
</html>