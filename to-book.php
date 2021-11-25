<?php
require_once "lib/Dataform.php";

$dataform = Dataform::getInstance($_GET);
// print_r($dataform);
print_r($_GET);

$_GET['test'] = [
    [
        'departure-city' => 'Paris',
        'arrival-city' => 'New-York',
        'date-selected' => 'Jeu. 25',
        'trip_type' => 'round-trip',
        'price' => '150€',
    ],
];

$_GET['test1'] = [
    [
        'departure-city' => 'Marseille',
        'arrival-city' => 'Moscou',
        'date-selected' => 'Jeu. 25 nov 2021',
        'trip_type' => '',
        'price' => ''
    ],
];
// print_r($_GET);

$searchTrip = $_GET['trip-type'];

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
                <div class="card m-5 p-5">
                    <div class="outbound-flight">
                        <h3 class="card-title card-header text-white"><i class="fas fa-plane"></i> Vol aller:</h3>
                        <div class="card-title card-header text-white">
                            <p><?php echo $_GET['city-start']?></p>
                            <p><?php echo $_GET['city-to']?></p>
                        </div>
                    </div>
            
                    <div id="carouselExampleControls" class="carousel" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php for ($i=0; $i<30; $i++){ ?>
                                <?php setlocale(LC_TIME, "fr_FR"); 
                                echo strftime('%a. %d %b %G',strtotime($_GET['departure-date']));
                                    if ($_GET['test'][0]['date-selected'] == (strftime('%a', strtotime("$i day")) . '. ' . strftime('%d', strtotime("$i day")))){   
                                }?>
                            <div class="carousel-item active">
                                <div class="card card-item bg-light shadow-sm" onclick="changeCardBackgroundColor()">
                                    <div class="card card-item bg-light shadow-sm">
                                        <h4 class="card-header text-white">
                                        <?php setlocale(LC_TIME, "fr_FR"); 
                                            echo strftime('%a', strtotime("$i day")) . ". "; 
                                            echo strftime('%d', strtotime("$i day")) . " ";
                                            echo strftime('%b', strtotime("$i day")) . " "; 
                                            echo strftime('%Y');
                                        ?>
                                        </h4>
                                        <div class="card-body">
                                            <p class="card-text">
                                                <?php if ($_GET['test'][0]['price'] != ''){ ?>
                                                <div class="card-body" type="submit" onclick="getValue();" id="test" value="<?php echo $_GET['test'][0]['price'] ?>">
                                                    <?php echo 'à partir de ' .$_GET['test'][0]['price'] ?>
                                                </div>
                                            <?php } else { ?><div class="card-body-grey" type="submit">
                                                    Non disponible
                                                </div>
                                            <?php } ?></p>
                                        <a href="#" class="btn text-white" onclick="getValue();">Sélectionner</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>  
                        </div>
                        
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
                <?php if ('round-trip' == $searchTrip):?>
                    <div class="card m-5 p-5">
                        <div class="return">
                            <div class="return-flight">
                                <h3 class="card-title card-header text-white"><i class="fas fa-plane"></i> Vol aller:</h3>
                                <div class="card-title card-header text-white">
                                <p><?php echo $_GET['city-to']?></p>
                                <p><?php echo $_GET['city-start']?></p>
                            </div>
                            </div>
                            <div id="carouselExampleControls2" class="carousel" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    <?php for ($i=0; $i<30; $i++){ ?>
                                    <div class="carousel-item active">
                                        <div class="card card-item bg-light shadow-sm">
                                            <h4 class="card-header text-white">
                                                <?php setlocale(LC_TIME, "fr_FR"); 
                                                    echo strftime('%a', strtotime("$i day")) . ". "; 
                                                    echo strftime('%d', strtotime("$i day")) . " ";
                                                    echo strftime('%b', strtotime("$i day")) . " "; 
                                                    echo strftime('%Y');
                                                ?>
                                            </h4>
                                            <div class="card-body">
                                                <p class="card-text">
                                                    <?php if ($_GET['test'][0]['price'] != ''){ ?>
                                                    <div class="card-body" type="submit" onclick="getValue();" id="test" value="<?php echo $_GET['test'][0]['price'] ?>">
                                                        <?php echo 'à partir de ' . $_GET['test'][0]['price'] ?>
                                                    </div>
                                                <?php } else { ?><div class="card-body-grey" type="submit">
                                                        Non disponible
                                                    </div>
                                                <?php } ?></p>
                                                <a href="#" class="btn text-white" onclick="myFunction()">Sélectionner</a>
                                            </div>
                                        </div>
                                    </div>
                                    <?php } ?>  
                                </div>

                                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls2" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-success me-md-2 btn-lg" type="button">Réserver</button>
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