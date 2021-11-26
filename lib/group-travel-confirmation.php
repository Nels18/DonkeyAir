<?php
    session_start();
    require_once "lib/Dataform.php";
    require_once "lib/Validator.php";

    $dataForm = Dataform::getInstance($_GET);
    $valuesForm = [
        'city-start' => 'AAE, Annaba Les Salines - Algeria',
        'city-to' => 'KDH, Kandahar - Afghanistan',
        'departure-date' => '2021-01-02 15:38:31',
        'return-date' => '2021-01-02 23:55:27',
        'trip-class' => 'economy-class',
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
    $dataForm->testData($valuesForm);

    $validatorForm = new Validator($valuesForm);
    $_SESSION['fail-message'] = $validatorForm->getErrors(array_keys($valuesForm));
    // if (!empty($_SESSION['fail-message'])) {
    //     header('Location: group-travel.php');
    // }

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
        <?php include("/templates/confirmation.php"); ?>
    <script src="assets/js/main.js"></script>
    </body>
</html>