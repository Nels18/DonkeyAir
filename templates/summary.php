<?php

    session_start();
    require_once "lib/Dataform.php";
    require_once "lib/Validator.php";
    require_once 'lib/Database.php';

    setlocale(LC_TIME, 'fr','fr_FR','fr_FR@euro','fr_FR.utf8','fr-FR','fra');

    $isInConfirmationPage = ('/confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"]));
    $isInGroupTravelConfirmationPage = ('/group-travel-confirmation.php' == htmlspecialchars($_SERVER["PHP_SELF"]));

    $_SESSION['user-id'] = 1;
    $userId = $_SESSION['user-id'];

    if (!isset($_SESSION['user-id'])) {
        header("location:index.php");
    }

    ### fake user 
    $query = "SELECT * FROM customer WHERE id = $userId";
    $result = Database::getInstance()->query($query);
    $user = $result[0];


    $validatorForm = new Validator($_SESSION);
    $_SESSION['fail-message'] = $validatorForm->getErrors(array_keys($_SESSION));
    if (!empty($_SESSION['fail-message'])) {
        if ($isInConfirmationPage) {
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
                        <?php for ($i=0; $i < $_SESSION['number-of-passenger']; $i++): ?>
                            <?php 
                                if ($isInConfirmationPage && isset($_SESSION['number-of-passenger'])) {
                                    $titlePassengerNumber = "title-passenger-" . ($i + 1);
                                    $firstNamePassengerNumber = "first-name-passenger-" . ($i + 1);
                                    $lastNamePassengerNumber = "last-name-passenger-" . ($i + 1);
                                    if (isset($_POST['title-passenger-1'])) {
                                        echo "<p class=\"px-4 my-3\">Passager : ";
                                        echo $_POST[$titlePassengerNumber] . ". " . " " . $_POST[$firstNamePassengerNumber] . " " . $_POST[$lastNamePassengerNumber] . " ";
                                        echo $_SESSION['final-price'] . "€";
                                        echo "</p>";
                                    }
                                }
                            ?>
                            <div class="row border-bottom pb-5">
                                <div class="col-lg<?php if ('one-way' == isset($_SESSION['trip-type'])) echo "-6" ; ?>">
                                    <div class="card mt-5 rounded-3">
                                        <h4 class="card-title card-header text-white bg-primary">Vol aller</h4>
                                        <div class="card-body">
                                            <p>Depuis : <?= $_SESSION['departure-from'];?></p>
                                            <p>Vers : <?= $_SESSION['departure-to'];?></p>
                                            <p>Départ à 
                                                <?php
                                                $valuesFormTime = strftime('%H:%M ',strtotime($_SESSION['departure-time-outbound-flight']));
            
                                                if (!empty($_SESSION['departure-time-outbound-flight']) && strtotime($_SESSION['departure-time-outbound-flight'])) {
                                                    echo $valuesFormTime;
                                                };?>
                                            </p>
                                            <p>Arrivé à 
                                                <?php
                                                $valuesFormTime = strftime('%H:%M ',strtotime($_SESSION['arrival-time-outbound-flight']));
            
                                                if (!empty($_SESSION['arrival-time-outbound-flight']) && strtotime($_SESSION['arrival-time-outbound-flight'])) {
                                                    echo $valuesFormTime;
                                                };?>
                                            </p>
                                            <p>En classe <?= $_SESSION['trip-class'];?></p>
                                            <p>Avec l'option <?= $_SESSION['trip-option'];?></p>
                                            <?php if ($isInGroupTravelConfirmationPage): ;?>
                                                <p>Pour <?= $_SESSION['number-of-passenger'];?> personne(s)</p>
                                            <?php endif ;?>
                                        </div>
                                    </div>
                                </div>
                                <?php if('round-trip' == $_SESSION['trip-type']): ;?>
                                    <div class="col">
                                        <div class="card mt-5 rounded-3">
                                            <h4 class="card-title card-header text-white bg-primary">Vol retour</h4>
                                            <div class="card-body">
                                                <p>Depuis : <?= $_SESSION['departure-to'];?></p>
                                                <p>Vers : <?= $_SESSION['departure-from'];?></p>
                                                <p>Départ à
                                                    <?php
                                                    $valuesFormTime = strftime('%H:%M ',strtotime($_SESSION['departure-time-return-flight']));
            
                                                    if (!empty($_SESSION['departure-time-return-flight']) && strtotime($_SESSION['departure-time-return-flight'])) {
                                                        echo $valuesFormTime;
                                                    };?>
                                                </p>
                                                <p>Arrivé à
                                                    <?php
                                                    $valuesFormTime = strftime('%H:%M ',strtotime($_SESSION['arrival-time-return-flight']));
            
                                                    if (!empty($_SESSION['arrival-time-return-flight']) && strtotime($_SESSION['arrival-time-return-flight'])) {
                                                        echo $valuesFormTime;
                                                    };?>
                                                </p>
                                                <p>En classe <?= $_SESSION['trip-class'];?></p>
                                                <p>Avec l'option <?= $_SESSION['trip-option'];?></p>
                                                <?php if ($isInGroupTravelConfirmationPage): ;?>
                                                    <p>Pour <?= $_SESSION['number-of-passenger'];?> personne(s)</p>
                                                <?php endif ;?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endif ;?>
                            </div>
                        <?php endfor; ?>
                    <?php else: ?>
                        <div class="row border-bottom pb-5">
                            <div class="col-lg<?php if ('one-way' == isset($_SESSION['trip-type'])) echo "-6" ; ?>">
                                <div class="card mt-5 rounded-3">
                                    <h4 class="card-title card-header text-white bg-primary">Vol aller</h4>
                                    <div class="card-body">
                                        <p>Depuis : <?= isset($_SESSION['departure-time-return-flight']);?></p>
                                        <p>Vers : <?= $_SESSION['arrival-time-return-flight'];?></p>
                                        <p>Départ à 
                                            <?php
                                            $valuesFormTime = strftime('%H:%M ',strtotime($_SESSION['departure-from']));
        
                                            if (!empty($_SESSION['departure-from']) && strtotime($_SESSION['departure-from'])) {
                                                echo $valuesFormTime;
                                            };?>
                                        </p>
                                        <p>Arrivé à 
                                            <?php
                                            $valuesFormTime = strftime('%H:%M ',strtotime($_SESSION['departure-to']));
        
                                            if (!empty($_SESSION['departure-to']) && strtotime($_SESSION['departure-to'])) {
                                                echo $valuesFormTime;
                                            };?>
                                        </p>
                                        <p>En classe <?= $_SESSION['trip-class'];?></p>
                                        <p>Avec l'option <?= $_SESSION['trip-option'];?></p>
                                        <?php if ($isInGroupTravelConfirmationPage): ;?>
                                            <p>Pour <?= $_SESSION['number-of-passenger'];?> personne(s)</p>
                                        <?php endif ;?>
                                    </div>
                                </div>
                            </div>
                            <?php if('round-trip' == $_SESSION['trip-type']): ;?>
                                <div class="col">
                                    <div class="card mt-5 rounded-3">
                                        <h4 class="card-title card-header text-white bg-primary">Vol retour</h4>
                                        <div class="card-body">
                                            <p>Depuis : <?= $_SESSION['city-to'];?></p>
                                            <p>Vers : <?= $_SESSION['city-start'];?></p>
                                            <p>Départ à
                                                <?php
                                                $valuesFormTime = strftime('%H:%M ',strtotime($_SESSION['departure-time-return-flight']));
        
                                                if (!empty($_SESSION['departure-time-return-flight']) && strtotime($_SESSION['departure-time-return-flight'])) {
                                                    echo $valuesFormTime;
                                                };?>
                                            </p>
                                            <p>Arrivé à
                                                <?php
                                                $valuesFormTime = strftime('%H:%M ',strtotime($_SESSION['arrival-time-return-flight']));
        
                                                if (!empty($_SESSION['arrival-time-return-flight']) && strtotime($_SESSION['arrival-time-return-flight'])) {
                                                    echo $valuesFormTime;
                                                };?>
                                            </p>
                                            <p>En classe <?= $_SESSION['trip-class'];?></p>
                                            <p>Avec l'option <?= $_SESSION['trip-option'];?></p>
                                            <?php if ($isInGroupTravelConfirmationPage): ;?>
                                                <p>Pour <?= $_SESSION['number-of-passenger'];?> personne(s)</p>
                                            <?php endif ;?>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ;?>
                        </div>    
                    <?php endif ;?>
                </div>
                <?php if ($isInConfirmationPage): ;?>
                    <div class="row justify-content-between">
                        <p class="col-md-6 col-xl-4 my-3 d-grid">
                            Total : <?php echo $_SESSION['number-of-passenger'] * $_SESSION['final-price'] . "€" ?>
                        </p>
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