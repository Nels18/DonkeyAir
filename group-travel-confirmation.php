<?php
    session_start();
    require_once "lib/functions.php";
    require_once "lib/Dataform.php";
    require_once "lib/Validator.php";

    $dataForm = Dataform::getInstance($_GET);
    testData($dataForm);

    $valuesForm = [
        'city-start' => $dataForm->getValue('city-start'),
        'city-to' => $dataForm->getValue('city-to'),
        'departure-date' => $dataForm->getValue('departure-date'),
        'return-date' => $dataForm->getValue('return-date'),
        'trip-class' => $dataForm->getValue('trip-class'),
        'trip-type' => $dataForm->getValue('trip-type'),
        'number-of-passenger' =>$dataForm->getValue('number-of-passenger'),
    ];
    $validatorForm = new Validator($valuesForm);
    $_SESSION['fail-message'] = $validatorForm->getErrors(array_keys($valuesForm));
    if (!empty($_SESSION['fail-message'])) {
        header('Location: group-travel.php');
    }

    setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');

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
                            <div class="col<?php
                            if ('one-way' == $valuesForm['trip-type']) echo "-6" ;
                            ?>">
                                <div class="card mt-5 rounded-3 bg-primary text-white">
                                    <h4 class="card-header">Vol aller</h4>
                                    <div class="card-body">
                                        <p>Depuis : <?= $valuesForm['city-start'];?></p>
                                        <p>Vers : <?= $valuesForm['city-to'];?></p>
                                        <p>Le <?php
                                        echo strftime('%a. %d %b %G',strtotime($valuesForm['departure-date']));

                                            $valuesForm['departure-date'] = strftime('%a. %d %b %G',strtotime($valuesForm['departure-date']));
                                            if (!empty($valuesForm['departure-date']) && strtotime($valuesForm['departure-date'])) {
                                                echo $valuesForm['departure-date'];
                                            };?></p>
                                        <p>En classe <?= Dataform::translateTripClass($valuesForm['trip-class']);?></p>
                                    </div>
                                </div>
                            </div>
                            <?php if('round-trip' == $valuesForm['trip-type']): ;?>
                                <div class="col">
                                    <div class="card mt-5 rounded-3 bg-primary text-white">
                                        <h4 class="card-header">Vol retour</h4>
                                        <div class="card-body">
                                            <p>Depuis : <?= $valuesForm['city-to'];?></p>
                                            <p>Vers : <?= $valuesForm['city-start'];?></p>
                                            <p>Le <?php
                                            echo strftime('%a. %d %b %G',strtotime($valuesForm['return-date']));

                                            $valuesForm['return-date'] = strftime('%a. %d %b %G',strtotime($valuesForm['return-date']));
                                            if (!empty($valuesForm['return-date']) && strtotime($valuesForm['return-date'])) {
                                                echo $valuesForm['return-date'];
                                            };?></p>
                                            <p>En classe <?= Dataform::translateTripClass($valuesForm['trip-class']);?></p>
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