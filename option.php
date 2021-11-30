
<?php

session_start();
require_once "lib/Database.php";


$data = Database::getInstance();
// var_dump($_SESSION);
//die;
// if (isset($_SESSION['choix']) && $_SESSION['choix'] == 'Yes') {
//   $optionChoisi = $_SESSION['optionBasic'];
//    }
// if (isset($_SESSION['choix2']) && $_SESSION['choix2'] == 'Yes') {
//     $optionChoisi = $_SESSION['optionFlex'];
//      }
// if (isset($_SESSION['choix3']) && $_SESSION['choix3'] == 'Yes') {
//       $optionChoisi = $_SESSION['optionMax'];
// }
  $query2= "SELECT * FROM `option`";
  $resultat2= Database::getInstance()->query($query2);
  $option= $resultat2;



// foreach ($resultat2 as $key){
//   var_dump($key ['id']);
//   var_dump($key ['name']);

//   var_dump($key['multiplier_coefficient']);
// }

  // var_dump($resultat2);

  // $_SESSION['option'] = $_POST['option'];
  // var_dump($resultat2);
  $optionChoice= $_POST["option"];

  $requestMultiplierCoefficientOption = "SELECT multiplier_coefficient 
  FROM `option`
  WHERE name = '$optionChoice';";
  $resultMultiplierCoefficientOption = $data->query($requestMultiplierCoefficientOption);
  $_SESSION['outbound-flight-final-price'] = $_SESSION["outbound-flight-price-with-class"] * $resultMultiplierCoefficientOption[0]["multiplier_coefficient"];
  $_SESSION['return-flight-final-price'] = $_SESSION["return-flight-price-with-class"] * $resultMultiplierCoefficientOption[0]["multiplier_coefficient"];
  $_SESSION["final-price"] = $_SESSION['outbound-flight-final-price'] + $_SESSION['return-flight-final-price'];
  // var_dump($resultat2);
  // var_dump($_SESSION['outbound-flight-final-price']);
    
    // var_dump($option);
    
?>


Ò
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DonkeyAir</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css" type="text/css">
  </head>

  <body>  
    <main class="container-fluid bg-image">
      <form action="option.php" method="post">
        <div class="card-group">
          <div class="card">
            <div class="card-body">
              <p class="card-text"> <h2>Basic</h2><br><br>
              <p>Bagages supplementaire</p><br>
              <p>Billet Modifiable</p><br>
              <p>Annulation du billet</p><br>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="radio" name="option" value="Basic"/>
              </div>
            </p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <p class="card-text"> <h2>Flex</h2><br><br>
              <p>Bagages supplementaire</p><br>
              <p>Billet Modifiable</p><br>
              <p>Annulation du billet</p><br>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="radio" name="option" value="Plus"/>
              </div>
            </p>
          </div>
        </div>

        <div class="card">
          <div class="card-body">
            <p class="card-text"> <h2>Max</h2><br><br>
            <p>Bagages supplementaire</p><br>
            <p>Billet Modifiable</p><br>
            <p>Annulation du billet</p><br>
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <input type="radio" name="option" value="Max"/>
            </div>
          </p>
        </div>
          
        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a href="confirmation.php">
          <input class="btn btn-primary" type="button" value="Valider">
        </a>
        </div>
    </form>
    </main>
  </body>
</html>