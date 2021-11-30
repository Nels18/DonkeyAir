<?php
    session_start();

    require_once "lib/Validator.php";

    // session_unset();

    // var_dump($_SESSION);

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
        'number-of-passenger' => '3',
    ];

    // var_dump($valuesForm['city-to'] == $valuesForm['city-start']);
    // $dataForm->testData($valuesForm);

    $validatorForm = new Validator($valuesForm);
    // var_dump($validatorForm->mustBeDifferent());

    
    // $_SESSION['fail-message'] = $validatorForm->getErrors(array_keys($valuesForm));
    // if (!empty($_SESSION['fail-message'])) {
    //     header('Location: form-passenger.php');
    // }
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
                    <form action="confirmation.php" method="post">
                        <?php for ($i=0; $i < $valuesForm['number-of-passenger']; $i++): ?>
                            <?php
                            $titlePassengerNumber = "title-passenger-" . ($i + 1);
                            $firstNamePassengerNumber = "first-name-passenger-" . ($i + 1);
                            $lastNamePassengerNumber = "last-name-passenger-" . ($i + 1);
                            ?>
                            <div class="row">
                                <div class="col-md-2 mb-3">
                                    <label for="<?php echo $titlePassengerNumber; ?>" class="form-label">Civilité :</label>
                                    <select class="form-select" id="<?php echo $titlePassengerNumber; ?>" name="<?php echo $titlePassengerNumber; ?>" required>
                                        <option value="Mme" <?php 
                                        if ("Mme" == isset($valuesForm[$titlePassengerNumber]) || empty($valuesForm[$titlePassengerNumber])) {
                                            echo "selected";
                                        };?> >Madame</option>
                                        <option value="M" <?php
                                        if ("M" == isset($valuesForm[$titlePassengerNumber])) {
                                            "selected";  
                                        };?> >Monsieur</option>
                                    </select>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="<?php echo $firstNamePassengerNumber; ?>" class="form-label">Prénom :</label>
                                    <input type="text" class="form-control" id="<?php echo $firstNamePassengerNumber; ?>" name="<?php echo $firstNamePassengerNumber; ?>" value="<?php
                                    if (isset($valuesForm['firstNamePassengerNumber'])) {
                                        echo $valuesForm['firstNamePassengerNumber'];
                                        }
                                    ?>" required>
                                </div>
                                <div class="col-md mb-3" id="return-flight">
                                    <label for="<?php echo $lastNamePassengerNumber; ?>" class="form-label">Nom :</label>
                                    <input type="text" class="form-control" id="<?php echo $lastNamePassengerNumber; ?>" name="<?php echo $lastNamePassengerNumber; ?>" value="<?php 
                                    if (isset($valuesForm['lastNamePassengerNumber'])) {
                                        echo $valuesForm['lastNamePassengerNumber'];
                                    };?>" required>
                                </div>
                            </div>
                            <?php endfor; ?>
                        <div class="row">
                            <div class="col">
                                <?php
                                if (isset($_SESSION['fail-message'])) {

                                    $_SESSION['fail-message'];
                                    foreach ($_SESSION['fail-message'] as $key => $value) {
                                        echo "<p class=\"text-danger\">".$value ."</p>";
                                    }
                                }
                                session_unset()
                                ?>
                            </div>
                        </div>
                        
                        <div class="row justify-content-end">
                            <div class="col-md-6 col-xl-4 mb-3 d-grid">
                                <button type="submit" class="btn btn-primary btn-lg px-5 my-3">Confirmer</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <script src="assets/js/main.js"></script>
    </body>
</html>
