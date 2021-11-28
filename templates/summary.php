<?php

    session_start();
    require_once "lib/Dataform.php";
    require_once "lib/Validator.php";
    require_once 'lib/Database.php';
    $dataForm = Dataform::getInstance($_GET);

    var_dump($_SESSION);

    //fake
    $valuesForm = [
        'city-start' => 'AAE, Annaba Les Salines - Algeria',
        'city-to' => 'KDH, Kandahar - Afghanistan',
        'departure-from' => '2020-12-09 00:09:10',
        'departure-to' => '2020-12-09 02:23:27',
        'return-from' => '2021-11-23 14:29:04',
        'return-to' => '2021-11-23 18:22:00',
        'trip-class' => 'Économique',
        'trip-option' => 'Plus',
        'trip-type' => 'round-trip',
        'number-of-passenger' => '13',
    ];
        // var_dump($valuesForm);

        // $valuesForm = [
        //     'city-start' => $dataForm->getValue('city-start'),
        //     'city-to' => $dataForm->getValue('city-to'),
        //     'departure-date' => $dataForm->getValue('departure-date'),
        //     'return-date' => $dataForm->getValue('return-date'),
        //     'trip-class' => $dataForm->getValue('trip-class'),
        //     'trip-type' => $dataForm->getValue('trip-type'),
        //     'number-of-passenger' =>$dataForm->getValue('number-of-passenger'),
        // ];

    $_SESSION['user-id'] = 1;
    $userId = $_SESSION['user-id'];

    if (!isset($_SESSION['user-id'])) {
        header("location:index.php");
    }

    $query = "SELECT * FROM customer WHERE id = $userId";
    $result = Database::getInstance()->query($query);
    $user = $result[0];

    // var_dump($user);
    // var_dump($user['title']);

    $dataForm->testData($valuesForm);

    $validatorForm = new Validator($valuesForm);
    $_SESSION['fail-message'] = $validatorForm->getErrors(array_keys($valuesForm));
    if (!empty($_SESSION['fail-message'])) {
        header('Location: group-travel.php');
    }

    setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
?>

<main class="container-fluid bg-image">
    <div class="row justify-content-center">
        <div class="col-10 card p-5 m-5 rounded-3">
            <div class="card-body">
                <?php if ('/group-travel-confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"])): ;?>
                    <h2 class="card-title">Votre demande a été envoyé.</h2>
                    <p class="card-text mb-5">Nous traiteront votre demande dans les plus brèves délais.</p>
                <?php else: ;?>
                    <h2 class="card-title">Récapitulatif de votre réservation.</h2>
                    <p class="card-text mb-5">Veuillez vérifier les informations de votre réservation et la valider </p>
                <?php endif ;?>

                <div class="row justify-content-md-center border-top">
                    <h3 class="my-3">Récapitulatif</h3>
                    <?php if ('/confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"])): ;?>
                        <p class="customer-header">
                            <?php echo $user['title'] . ". " . $user['first_name'] . " " . $user['last_name']; ?>
                        </p>
                    <?php endif ;?>
                    <div class="col<?php
                    if ('one-way' == $valuesForm['trip-type']) echo "-6" ;
                    ?>">
                        <div class="card mt-5 rounded-3">
                            <h4 class="card-title card-header text-white bg-primary">Vol aller</h4>
                            <div class="card-body">
                                <p>Depuis : <?= $valuesForm['city-start'];?></p>
                                <p>Vers : <?= $valuesForm['city-to'];?></p>
                                <p>Départ à 
                                    <?php
                                    $valuesFormTime = strftime('%H:%M ',strtotime($valuesForm['departure-from']));

                                    if (!empty($valuesForm['departure-from']) && strtotime($valuesForm['departure-from'])) {
                                        echo $valuesFormTime;
                                    };?>
                                </p>
                                <p>Arrivé à 
                                    <?php
                                    $valuesFormTime = strftime('%H:%M ',strtotime($valuesForm['departure-to']));

                                    if (!empty($valuesForm['departure-to']) && strtotime($valuesForm['departure-to'])) {
                                        echo $valuesFormTime;
                                    };?>
                                </p>
                                <p>En classe <?= $valuesForm['trip-class'];?></p>
                                <p>Avec l'option <?= $valuesForm['trip-option'];?></p>
                                <?php if ('/group-travel-confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"])): ;?>
                                    <p>Pour <?= $valuesForm['number-of-passenger'];?> personne(s)</p>
                                <?php endif ;?>
                            </div>
                        </div>
                    </div>
                    <?php if('round-trip' == $valuesForm['trip-type']): ;?>
                        <div class="col">
                            <div class="card mt-5 rounded-3">
                                <h4 class="card-title card-header text-white bg-primary">Vol retour</h4>
                                <div class="card-body">
                                    <p>Depuis : <?= $valuesForm['city-to'];?></p>
                                    <p>Vers : <?= $valuesForm['city-start'];?></p>
                                    <p>Départ à
                                        <?php
                                        $valuesFormTime = strftime('%H:%M ',strtotime($valuesForm['return-from']));

                                        if (!empty($valuesForm['return-from']) && strtotime($valuesForm['return-from'])) {
                                            echo $valuesFormTime;
                                        };?>
                                    </p>
                                    <p>Arrivé à
                                        <?php
                                        $valuesFormTime = strftime('%H:%M ',strtotime($valuesForm['return-to']));

                                        if (!empty($valuesForm['return-to']) && strtotime($valuesForm['return-to'])) {
                                            echo $valuesFormTime;
                                        };?>
                                    </p>
                                    <p>En classe <?= $valuesForm['trip-class'];?></p>
                                    <p>Avec l'option <?= $valuesForm['trip-option'];?></p>
                                    <?php if ('/group-travel-confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"])): ;?>
                                        <p>Pour <?= $valuesForm['number-of-passenger'];?> personne(s)</p>
                                    <?php endif ;?>
                                </div>
                            </div>
                        </div>
                    <?php endif ;?>
                </div>
                <?php if ('/confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"])): ;?>
                    <div class="row justify-content-end">
                        <div class="col-md-6 col-xl-4 my-3 d-grid">
                            <a href="create-booking.php">
                                <button class="btn btn-primary btn-lg px-5 my-3">Confirmer votre réservation</button>
                            </a>
                        </div>
                    </div>
                <?php endif ;?>
            </div>
        </div>
    </div>
</main>