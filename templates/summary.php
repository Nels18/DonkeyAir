<?php

    session_start();
    require_once "lib/Dataform.php";
    require_once "lib/Validator.php";
    require_once 'lib/Database.php';

    setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');

    $isInConfirmationPage = ('/confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"]));
    $isInGroupTravelConfirmationPage = ('/group-travel-confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"]));
    if ($isInConfirmationPage) {
        $dataForm = Dataform::getInstance($_POST)->getData();
    } elseif ($isInGroupTravelConfirmationPage) {
        $dataForm = Dataform::getInstance($_GET)->getData();
    }

    // if (!isset($dataForm)) {
    //     header("location:index.php");
    // }
    var_dump($_POST) ;
    var_dump($dataForm) ;
        ### fake value from db
        
        // $dataForm = [
        //     'city-start' => 'AAE, Annaba Les Salines - Algeria',
        //     'city-to' => 'KDH, Kandahar - Afghanistan',
        //     'departure-from' => '2020-12-09 00:09:10',
        //     'departure-to' => '2020-12-09 02:23:27',
        //     'return-from' => '2021-11-23 14:29:04',
        //     'return-to' => '2021-11-23 18:22:00',
        //     'trip-class' => 'Économique',
        //     'trip-option' => 'Plus',
        //     'trip-type' => 'round-trip',
        //     'number-of-passenger' => '3',
        // ];

    $_SESSION['user-id'] = 1;
    $userId = $_SESSION['user-id'];

    if (!isset($_SESSION['user-id'])) {
        header("location:index.php");
    }

    ### fake user 
    $query = "SELECT * FROM customer WHERE id = $userId";
    $result = Database::getInstance()->query($query);
    $user = $result[0];

    // var_dump($user);
    // var_dump($user['title']);

    // $dataForm->getData($_POST);

    $validatorForm = new Validator($dataForm);
    // var_dump($validatorForm->getErrors());
    $_SESSION['fail-message'] = $validatorForm->getErrors(array_keys($dataForm));
    if (!empty($_SESSION['fail-message'])) {
        if ($isInConfirmationPage) {
            // if (array_key_exists('search-form-not-filled',$_SESSION['fail-message'])) {
            //     header('Location: index.php');
            // }
            header('Location: form-passenger.php');
        } else {
            header('Location: group-travel.php');
        }
    }

    setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');
?>

<main class="container-fluid">
    <div class="row justify-content-center bg-image">
        <div class="col-10 card p-5 m-5 rounded-3">
            <div class="card-body">
                <?php if ($isInGroupTravelConfirmationPage): ;?>
                    <h2 class="card-title">Votre demande a été envoyé.</h2>
                    <p class="card-text mb-5">Nous traiteront votre demande dans les plus brèves délais.</p>
                <?php else: ;?>
                    <h2 class="card-title mb-3">Récapitulatif de votre réservation.</h2>
                <?php endif ;?>
                <div class="row justify-content-md-center border-top">
                    <?php if ($isInConfirmationPage): ;?>
                        <p class="customer-header mt-3">
                            <?php echo $user['title'] . ". " . $user['first_name'] . " " . $user['last_name']; ?>
                        </p>
                    <?php endif ;?>
                    <p class="card-text mb-5">Veuillez vérifier les informations de votre réservation et la valider.</p>
                    <?php if ($isInConfirmationPage): ;?>
                        <?php for ($i=0; $i < $dataForm['number-of-passenger']; $i++): ?>
                            <?php 
                                if ($isInConfirmationPage && isset($dataForm['number-of-passenger'])) {
                                    $titlePassengerNumber = "title-passenger-" . ($i + 1);
                                    $firstNamePassengerNumber = "first-name-passenger-" . ($i + 1);
                                    $lastNamePassengerNumber = "last-name-passenger-" . ($i + 1);
                                    if (isset($dataForm['title-passenger-1'])) {
                                        echo "<p class=\"px-4 my-3\">Passager : ";
                                        echo $dataForm[$titlePassengerNumber] . ". " . " " . $dataForm[$firstNamePassengerNumber] . " " . $dataForm[$lastNamePassengerNumber];
                                        echo "</p>";
                                    }
                                }
                            ?>
                            <div class="row border-bottom pb-5">
                                <div class="col-lg<?php if ('one-way' == isset($dataForm['trip-type'])) echo "-6" ; ?>">
                                    <div class="card mt-5 rounded-3">
                                        <h4 class="card-title card-header text-white bg-primary">Vol aller</h4>
                                        <div class="card-body">
                                            <p>Depuis : <?= isset($dataForm['city-start']);?></p>
                                            <p>Vers : <?= $dataForm['city-to'];?></p>
                                            <p>Départ à 
                                                <?php
                                                $valuesFormTime = strftime('%H:%M ',strtotime($dataForm['departure-from']));
            
                                                if (!empty($dataForm['departure-from']) && strtotime($dataForm['departure-from'])) {
                                                    echo $valuesFormTime;
                                                };?>
                                            </p>
                                            <p>Arrivé à 
                                                <?php
                                                $valuesFormTime = strftime('%H:%M ',strtotime($dataForm['departure-to']));
            
                                                if (!empty($dataForm['departure-to']) && strtotime($dataForm['departure-to'])) {
                                                    echo $valuesFormTime;
                                                };?>
                                            </p>
                                            <p>En classe <?= $dataForm['trip-class'];?></p>
                                            <p>Avec l'option <?= $dataForm['trip-option'];?></p>
                                            <?php if ($isInGroupTravelConfirmationPage): ;?>
                                                <p>Pour <?= $dataForm['number-of-passenger'];?> personne(s)</p>
                                            <?php endif ;?>
                                        </div>
                                    </div>
                                </div>
                                <?php if('round-trip' == $dataForm['trip-type']): ;?>
                                    <div class="col">
                                        <div class="card mt-5 rounded-3">
                                            <h4 class="card-title card-header text-white bg-primary">Vol retour</h4>
                                            <div class="card-body">
                                                <p>Depuis : <?= $dataForm['city-to'];?></p>
                                                <p>Vers : <?= $dataForm['city-start'];?></p>
                                                <p>Départ à
                                                    <?php
                                                    $valuesFormTime = strftime('%H:%M ',strtotime($dataForm['return-from']));
            
                                                    if (!empty($dataForm['return-from']) && strtotime($dataForm['return-from'])) {
                                                        echo $valuesFormTime;
                                                    };?>
                                                </p>
                                                <p>Arrivé à
                                                    <?php
                                                    $valuesFormTime = strftime('%H:%M ',strtotime($dataForm['return-to']));
            
                                                    if (!empty($dataForm['return-to']) && strtotime($dataForm['return-to'])) {
                                                        echo $valuesFormTime;
                                                    };?>
                                                </p>
                                                <p>En classe <?= $dataForm['trip-class'];?></p>
                                                <p>Avec l'option <?= $dataForm['trip-option'];?></p>
                                                <?php if ($isInGroupTravelConfirmationPage): ;?>
                                                    <p>Pour <?= $dataForm['number-of-passenger'];?> personne(s)</p>
                                                <?php endif ;?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ;?>
                            </div>
                        <?php endfor; ?>
                    <?php endif ;?>
                    <div class="row border-bottom pb-5">
                        <div class="col-lg<?php if ('one-way' == isset($dataForm['trip-type'])) echo "-6" ; ?>">
                            <div class="card mt-5 rounded-3">
                                <h4 class="card-title card-header text-white bg-primary">Vol aller</h4>
                                <div class="card-body">
                                    <p>Depuis : <?= isset($dataForm['city-start']);?></p>
                                    <p>Vers : <?= $dataForm['city-to'];?></p>
                                    <p>Départ à 
                                        <?php
                                        $valuesFormTime = strftime('%H:%M ',strtotime($dataForm['departure-from']));
    
                                        if (!empty($dataForm['departure-from']) && strtotime($dataForm['departure-from'])) {
                                            echo $valuesFormTime;
                                        };?>
                                    </p>
                                    <p>Arrivé à 
                                        <?php
                                        $valuesFormTime = strftime('%H:%M ',strtotime($dataForm['departure-to']));
    
                                        if (!empty($dataForm['departure-to']) && strtotime($dataForm['departure-to'])) {
                                            echo $valuesFormTime;
                                        };?>
                                    </p>
                                    <p>En classe <?= $dataForm['trip-class'];?></p>
                                    <p>Avec l'option <?= $dataForm['trip-option'];?></p>
                                    <?php if ($isInGroupTravelConfirmationPage): ;?>
                                        <p>Pour <?= $dataForm['number-of-passenger'];?> personne(s)</p>
                                    <?php endif ;?>
                                </div>
                            </div>
                        </div>
                        <?php if('round-trip' == $dataForm['trip-type']): ;?>
                            <div class="col">
                                <div class="card mt-5 rounded-3">
                                    <h4 class="card-title card-header text-white bg-primary">Vol retour</h4>
                                    <div class="card-body">
                                        <p>Depuis : <?= $dataForm['city-to'];?></p>
                                        <p>Vers : <?= $dataForm['city-start'];?></p>
                                        <p>Départ à
                                            <?php
                                            $valuesFormTime = strftime('%H:%M ',strtotime($dataForm['return-from']));
    
                                            if (!empty($dataForm['return-from']) && strtotime($dataForm['return-from'])) {
                                                echo $valuesFormTime;
                                            };?>
                                        </p>
                                        <p>Arrivé à
                                            <?php
                                            $valuesFormTime = strftime('%H:%M ',strtotime($dataForm['return-to']));
    
                                            if (!empty($dataForm['return-to']) && strtotime($dataForm['return-to'])) {
                                                echo $valuesFormTime;
                                            };?>
                                        </p>
                                        <p>En classe <?= $dataForm['trip-class'];?></p>
                                        <p>Avec l'option <?= $dataForm['trip-option'];?></p>
                                        <?php if ($isInGroupTravelConfirmationPage): ;?>
                                            <p>Pour <?= $dataForm['number-of-passenger'];?> personne(s)</p>
                                        <?php endif ;?>
                                    </div>
                                </div>
                            </div>
                        <?php endif ;?>
                    </div>
                </div>
                <?php if ($isInConfirmationPage): ;?>
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