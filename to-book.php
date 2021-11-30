<?php

session_start();

// Use Dataform, Validator and Database classes
require_once "lib/Dataform.php";
require_once "lib/Validator.php";
require_once 'lib/Database.php';

setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');

$data = Database::getInstance();
$dataform = Dataform::getInstance($_POST);

// Get datas from form-search.php using $_POST
$searchTrip = $_POST['trip-type'];
$cityStart = substr($_POST['city-start'], 0, 3);
$cityTo = substr($_POST['city-to'], 0, 3);
$tripClass = $_POST['trip-class'];
$numberOfPassenger = $_POST['number-of-passenger'];
$tripType = $_POST['trip-type'];

// Get datas from donkeyair database using SQL requests
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

// Set datas into arrays in order to extract them
$resultPriceOutbound = $data->query($requestPriceOutbound);
$resultPriceReturn = $data->query($requestPriceReturn);
$resultOutboundFlightID = $data->query($requestOutboundFlightID);
$resultReturnFlightID = $data->query($requestReturnFlightID);
$resultMultiplierCoefficient = $data->query($requestMultiplierCoefficient);
$resultIdAvailableOutboundFlight = $data->query($requestIdAvailableOutboundFlight);
$resultAvailableOutboundFlight = $data->query($requestAvailableOutboundFlight);
$resultAvailableReturnFlight = $data->query($requestAvailableReturnFlight);

if (isset($resultAvailableOutboundFlight[0]['departure_date'], $resultAvailableReturnFlight[0]['departure_date'])) {
    $departureTimeOutboundFlight = strftime('%H%M',strtotime($resultAvailableOutboundFlight[0]['departure_date']));
    $arrivalTimeOutboundFlight = strftime('%H%M',strtotime($resultAvailableOutboundFlight[0]['arrival_date']));
    $departureTimeReturnFlight = strftime('%H%M',strtotime($resultAvailableReturnFlight[0]['departure_date']));
    $arrivalTimeReturnFlight = strftime('%H%M',strtotime($resultAvailableReturnFlight[0]['arrival_date']));
    $idOutboundFlight = $resultOutboundFlightID[0]['id'];
    $idReturnFlight = $resultReturnFlightID[0]['id']; 
}

// Set datas into $_SESSION
$_SESSION['trip-class'] = $tripClass;
$_SESSION['number-of-passenger'] = $numberOfPassenger;
$_SESSION['trip-type'] = $tripType;
$_SESSION['outbound-flight-price-with-class'] = $resultPriceOutbound[0]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"];
$_SESSION['return-flight-price-with-class'] = $resultPriceOutbound[1]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"];
if (isset($resultPriceOutbound[1]['price'], $_SESSION['return-flight-price-with-class'])){
    $_SESSION['return-flight-price-with-class'] = $resultPriceOutbound[1]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"];
    $_SESSION['total-price'] = $_SESSION['outbound-flight-price-with-class'] + $_SESSION['return-flight-price-with-class'];
}

$_SESSION['departure-from'] = $_POST['city-start'];
$_SESSION['departure-to'] = $_POST['city-to'];
$_SESSION['return-from'] = $_POST['city-to'];
$_SESSION['return-to'] = $_POST['city-start'];
$_SESSION['departure-time-outbound-flight'] = $resultAvailableOutboundFlight[0]['departure_date'];
$_SESSION['arrival-time-outbound-flight'] = $resultAvailableOutboundFlight[0]['arrival_date'];
$_SESSION['departure-time-return-flight'] = $resultAvailableReturnFlight[0]['departure_date'];
$_SESSION['arrival-time-return-flight'] = $resultAvailableReturnFlight[0]['arrival_date'];
?>

<!doctype html>
<html lang="fr">
    <head>
        <!-- Required meta tags -->
        <title>Réservez un vol - Vols pas chers et billets d'avion au meilleur prix vers le monde entier | Site officiel de DonkeyAir</title>
        <meta name="description" content="Réservez un vol pas cher au meilleur prix vers plus le monde entier avec DonkeyAir. Connectez-vous et gérez la réservation de vos billets d'avion 100% modifiables et remboursables sur DonkeyAir. Vols aller simple, aller-retour">
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

        <!-- Bootstrap CSS -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
        <link href="assets/css/style.css" rel="stylesheet">
        <script src="https://kit.fontawesome.com/a24cbbc15d.js" crossorigin="anonymous"></script>
    </head>

    <!-- Flight(s) selection(s) with outbound/return flights in calendar sliders shaped with controllers to slide left or right, select buttons to choose flights and view the flight's informations and a booking button to confirm your choices -->
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
                                                <?php if (($i == 0) && isset($resultAvailableOutboundFlight[0]['departure_date'])){
                                                    echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date'] . " -1 day")));
                                                } elseif (($i == 1) && isset($resultAvailableOutboundFlight[0]['departure_date'])){ 
                                                    echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date']))); 
                                                } elseif(isset($resultAvailableOutboundFlight[0]['departure_date'])) 
                                                    echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date'] . " +$i day" . " -1 day")));
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
                                            <?php if (isset($resultAvailableOutboundFlight[0]['departure_date']))
                                                echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[0]['departure_date']))); ?>
                                        </div>
                                        <div>
                                            <i class="fas fa-clock"></i> 
                                            <?php if (isset($resultAvailableOutboundFlight[0]['departure_date']))
                                                echo(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[0]['departure_date']))); ?>
                                            <i class="fas fa-plane"></i> 
                                            <?php if (isset($resultAvailableOutboundFlight[0]['arrival_date']))
                                                echo(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[0]['arrival_date']))); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="card-title card-header">
                                        <div>
                                            Numéro de vol: 
                                            <?php if (isset($departureTimeOutboundFlight, $arrivalTimeReturnFlight, $idOutboundFlight))
                                                echo $cityStart.$cityTo.$departureTimeOutboundFlight.$arrivalTimeReturnFlight.$idOutboundFlight; ?>
                                        </div>
                                        <div>
                                            <?php if (isset($resultPriceOutbound[0]['price'], $resultMultiplierCoefficient[0]["multiplier_coefficient"]))
                                                echo $resultPriceOutbound[0]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"] . ' €' ?>
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
                                                    <?php if (($i == 0) && isset($resultAvailableOutboundFlight[1]['departure_date'])){
                                                        echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[1]['departure_date'] . " -1 day")));
                                                    } elseif (($i == 1) && isset($resultAvailableOutboundFlight[1]['departure_date'])){ 
                                                        echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[1]['departure_date']))); 
                                                    } elseif (isset($resultAvailableOutboundFlight[1]['departure_date']))
                                                        echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[1]['departure_date'] . " +$i day" . " -1 day")));
                                                    ?>
                                                </h4>
                                                <div class="card-body">
                                                    <p class="card-text">
                                                        <div class="card-body">
                                                            <?php if (($i == 1) && isset($resultPriceOutbound[1]['price'], $resultMultiplierCoefficient[0]["multiplier_coefficient"])) {
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
                                                        <?php if (isset($resultAvailableOutboundFlight[1]['departure_date']))
                                                            echo(strftime('%a. %d %b %G',strtotime($resultAvailableOutboundFlight[1]['departure_date']))); ?>
                                                    </div>
                                                    <div>
                                                        <i class="fas fa-clock"></i> 
                                                        <?php if (isset($resultAvailableOutboundFlight[1]['departure_date']))
                                                            echo(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[1]['departure_date']))); ?>
                                                        <i class="fas fa-plane"></i> 
                                                        <?php if (isset($resultAvailableOutboundFlight[1]['arrival_date']))
                                                            echo(strftime('%H:%M',strtotime($resultAvailableOutboundFlight[1]['arrival_date']))); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card-title card-header">
                                                    <div>
                                                        Numéro de vol: 
                                                        <?php if (isset($departureTimeReturnFlight, $arrivalTimeReturnFlight, $idReturnFlight))
                                                            echo $cityTo.$cityStart.$departureTimeReturnFlight.$arrivalTimeReturnFlight.$idReturnFlight; ?>
                                                    </div>
                                                    <div>
                                                        <?php if (isset($resultPriceOutbound[1]['price'], $resultMultiplierCoefficient[0]["multiplier_coefficient"]))
                                                            echo $resultPriceOutbound[1]['price'] * $resultMultiplierCoefficient[0]["multiplier_coefficient"] . ' €' ?>
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
                        <a href="option.php">
                            <button class="btn btn-success me-md-2 btn-lg" type="submit">Réserver</button>
                        </a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Option 1: Bootstrap Bundle with Popper -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

        <!-- Option 2: Separate Popper and Bootstrap JS -->
        <script src="assets/js/jQuery.js"></script>
        <script src="assets/js/main.js"></script>
    </body>
</html>