<?php
session_start();

require_once "lib/Dataform.php";
require_once "lib/Validator.php";
require_once 'lib/Database.php';

// setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
// $dataform = Dataform::getInstance($_POST);
// // var_dump($dataform->data);
// var_dump($dataform->getData());
// $validatorForm = new Validator($dataform->getData());
// $_SESSION['fail-message'] = $validatorForm->getErrors(array_keys($dataform->getData()));
// var_dump($_SESSION);
// if (!empty($_SESSION['fail-message'])) {
//     header('Location: index.php');
// }
// print_r($dataform);
// print_r($_GET);
// var_dump($dataform);

$searchTrip = $_GET['trip-type'];
$cityStart = substr($_GET['city-start'], 0, 3);
$cityTo = substr($_GET['city-to'], 0, 3);
$tripClass = $_GET['trip-class'];

$requestPriceOutbound = "SELECT price FROM airport 
LEFT JOIN flight ON airport.code = airport_from_code 
WHERE code = '$cityStart'";

$requestPriceReturn = "SELECT price FROM airport 
LEFT JOIN flight ON airport.code = airport_to_code 
WHERE code = '$cityTo'";

$requestOutboundFlightID = "SELECT id FROM airport 
LEFT JOIN flight ON airport.code = airport_from_code 
WHERE code = '$cityStart'";

$requestReturnFlightID = "SELECT id FROM airport 
LEFT JOIN flight ON airport.code = airport_to_code 
WHERE code = '$cityTo'";

$requestAvailableOutboundFlight = "SELECT a.name airport_name, f.airport_from_code, c.name country_name, f.price, f.departure_date, f.arrival_date
FROM flight f
INNER JOIN airport a ON a.code = f.airport_from_code
INNER JOIN country c ON c.code = a.country_code
WHERE f.airport_from_code = '$cityStart'";

$requestAvailableReturnFlight = "SELECT a.name airport_name, f.airport_to_code, c.name country_name, f.price, f.departure_date, f.arrival_date
FROM flight f
INNER JOIN airport a ON a.code = f.airport_to_code
INNER JOIN country c ON c.code = a.country_code
WHERE f.airport_to_code = '$cityTo'";

$requestMultiplierCoefficient = "SELECT multiplier_coefficient 
FROM class 
WHERE name = '$tripClass'";

$requestIdAvailableOutboundFlight = "SELECT a.name airport_name, f.airport_from_code, c.name country_name, f.price, f.departure_date, f.arrival_date, f.id
FROM flight f
INNER JOIN airport a ON a.code = f.airport_from_code
INNER JOIN country c ON c.code = a.country_code
WHERE f.airport_from_code = '$cityStart'";

$resultPriceOutbound = Database::getInstance()->query($requestPriceOutbound);
$resultPriceReturn = Database::getInstance()->query($requestPriceReturn);
$resultOutboundFlightID = Database::getInstance()->query($requestOutboundFlightID);
$resultReturnFlightID = Database::getInstance()->query($requestReturnFlightID);
$resultMultiplierCoefficient = Database::getInstance()->query($requestMultiplierCoefficient);
$resultIdAvailableOutboundFlight = Database::getInstance()->query($requestIdAvailableOutboundFlight);
// var_dump($resultIdAvailableOutboundFlight);
var_dump($resultMultiplierCoefficient);

$resultAvailableOutboundFlight = Database::getInstance()->query($requestAvailableOutboundFlight);
var_dump($resultAvailableOutboundFlight);
// strftime('%a. %d %b %G',strtotime($valuesForm['departure-date']))
// setlocale(LC_TIME, "fr_FR");
// var_dump(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date'])));
// var_dump(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[0]['departure_date'])));

$resultAvailableReturnFlight = Database::getInstance()->query($requestAvailableReturnFlight);
// strftime('%a. %d %b %G',strtotime($valuesForm['arrival-date']))
// var_dump(strftime('%a. %d %b %G',strtotime($resultAvailableReturnFlight[0]['arrival_date'])));
// var_dump(strftime('%H:%M',strtotime($resultAvailableReturnFlight[0]['departure_date'])));

$departureTimeOutboundFlight = strftime('%H%M',strtotime($resultAvailableOutboundFlight[0]['departure_date']));
$arrivalTimeOutboundFlight = strftime('%H%M',strtotime($resultAvailableOutboundFlight[0]['arrival_date']));
$departureTimeReturnFlight = strftime('%H%M',strtotime($resultAvailableReturnFlight[0]['departure_date']));
$arrivalTimeReturnFlight = strftime('%H%M',strtotime($resultAvailableReturnFlight[0]['arrival_date']));
$idOutboundFlight = $resultOutboundFlightID[0]['id'];
$idReturnFlight = $resultReturnFlightID[0]['id']; 

?>

<!doctype html>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="assets/css/style.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a24cbbc15d.js" crossorigin="anonymous"></script>
        <title>Réservez un vol - Vols pas chers et billets d'avion au meilleur prix vers le monde entier | Site officiel de DonkeyAir</title>
        <meta name="description" content="Réservez un vol pas cher au meilleur prix vers plus le monde entier avec DonkeyAir. Connectez-vous et gérez la réservation de vos billets d'avion 100% modifiables et remboursables sur DonkeyAir. Vols aller simple, aller-retour">
        <title>DonkeyAir</title>
    </head>

    <body>
    <main class="container-fluid bg-image"> 
        <div class="row justify-content-center">
            <div class="col-10 card p-5 m-5 rounded-3">
                <h2>Sélectionner vos vols</h2>
                <div class="card m-5">
                    <div class="outbound-flight">
                        <h3 class="card-title card-header text-white bg-primary"><i class="fas fa-plane"></i> Vol aller</h3>
                        <div class="card-title card-header">
                            <p><?php echo $_POST['city-start']?> <i class="fas fa-arrow-right"></i> <?php echo $_POST['city-to']?></p>
                        </div>
                    </div>

                    <div id="carouselExampleControls" class="carousel p-5" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php for ($i=0; $i<30; $i++){ ?>
                                <div class="carousel-item active">
                                    <div class="card card-item bg-light shadow-sm">
                                        <h4 class="card-header text-white bg-primary">
                                            <?php if ($i == 0){
                                                echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date'] . " -1 day")));
                                            } elseif ($i == 1) { 
                                                echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date']))); 
                                            } else echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date'] . " +$i day" . " -1 day")));
                                            ?>
                                        </h4>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <div class="card-body">
                                                    <?php if ($i == 1) {
                                                        echo 'à partir de ' .$resultPriceOutbound[0]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"] . ' €';
                                                    }
                                                    else echo 'Pas de vols disponibles';
                                                    ?>
                                                </div>
                                            </p>
                                            <div>
                                                <?php if ($i == 1){?>
                                                    <button class="btn btn-primary" type="button" id="btn-select-outbound">Sélectionner</button>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>  
                        </div>
                        <div class="row" id="selectedOutboundFlightInformations">
                            <div class="col-sm-6">
                                <div class="card-title card-header">
                                    <div>
                                        <?php echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date']))); ?>
                                    </div>
                                    <div>
                                        <i class="fas fa-clock"></i> 
                                        <?php echo(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[0]['departure_date']))); ?>
                                        <i class="fas fa-plane"></i> 
                                        <?php echo(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[0]['arrival_date']))); ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="card-title card-header">
                                    <div>
                                        Numéro de vol: 
                                        <?php echo $cityStart.$cityTo.$departureTimeOutboundFlight.$arrivalTimeReturnFlight.$idOutboundFlight; ?>
                                    </div>
                                    <div>
                                        <?php echo $resultPriceOutbound[0]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"] . ' €' ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <button class="carousel-control-prev m-3" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next m-3" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <?php if ('round-trip' == $searchTrip):?>
                    <div class="card m-5">
                        <div class="return">
                            <div class="return-flight">
                                <h3 class="card-title card-header text-white bg-primary"><i class="fas fa-plane"></i> Vol retour</h3>
                                <div class="card-title card-header">
                                    <p><?php echo $_POST['city-to']?> <i class="fas fa-arrow-right"></i> <?php echo $_POST['city-start']?></p>
                                </div>
                            </div>
                            <div id="carouselExampleControls2" class="carousel p-5" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php for ($i=0; $i<30; $i++){ ?>
                                    <div class="carousel-item active">
                                        <div class="card card-item bg-light shadow-sm">
                                            <h4 class="card-header text-white bg-primary">
                                                <?php if ($i == 0){
                                                    echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[1]['departure_date'] . " -1 day")));
                                                } elseif ($i == 1) { 
                                                    echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[1]['departure_date']))); 
                                                } else echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[1]['departure_date'] . " +$i day" . " -1 day")));
                                                ?>
                                            </h4>
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <div class="card-body">
                                                        <?php if ($i == 1) {
                                                            echo 'à partir de ' .$resultPriceOutbound[1]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"] . ' €';
                                                        }
                                                        else echo 'Pas de vols disponibles';
                                                        ?>
                                                    </div>
                                                </p>
                                                <div>
                                                    <?php if ($i == 1){?>
                                                        <button class="btn btn-primary" type="button" id="btn-select-return">Sélectionner</button>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>  
                                </div>
                                <div>
                                    <div class="row" id="selectedReturnFlightInformations">
                                        <div class="col-sm-6">
                                            <div class="card-title card-header">
                                                <div>
                                                    <?php echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[1]['departure_date']))); ?>
                                                </div>
                                                <div>
                                                    <i class="fas fa-clock"></i> 
                                                    <?php echo(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[1]['departure_date']))); ?>
                                                    <i class="fas fa-plane"></i> 
                                                    <?php echo(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[1]['arrival_date']))); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="card-title card-header">
                                                <div>
                                                    Numéro de vol: 
                                                    <?php echo $cityTo.$cityStart.$departureTimeReturnFlight.$arrivalTimeReturnFlight.$idReturnFlight; ?>
                                                </div>
                                                <div>
                                                    <?php echo $resultPriceOutbound[1]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"] . ' €' ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="carousel-control-prev m-3" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next m-3" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <a href="to-book.php?id=<?php echo $resultIdAvailableOutboundFlight[0]['id']?>">
                        <button class="btn btn-success me-md-2 btn-lg" type="button">Réserver</button>
                    </a>
                </div>
            </div>
        </div>
    </main>


        <!-- Optional JavaScript; choose one of the two! -->

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
        <script src="assets/js/jQuery.js"></script>
        <script src="assets/js/main.js"></script>
        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <!--
        <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
        -->
    </body>
</html>