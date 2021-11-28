<?php require_once('./lib/Database.php'); 

var_dump($_POST);
//die;
if (isset($_POST['choix']) && $_POST['choix'] == 'Yes') {
  $optionChoisi = $_POST['optionBasic'];
   }
if (isset($_POST['choix2']) && $_POST['choix2'] == 'Yes') {
    $optionChoisi = $_POST['optionFlex'];
     }
if (isset($_POST['choix3']) && $_POST['choix3'] == 'Yes') {
      $optionChoisi = $_POST['optionMax'];

  $query2= "SELECT * FROM option";
  $query2= Database:: getInstance()->query($query2);
  $option= $resultat2[0];

foreach ($resultat2 as $key){
  var_dump($key ['id']);
  var_dump($key ['name']);

  var_dump($key['multiplier_coefficient']);
}


    }
?>



<!DOCTYPE html>
<html lang="en">
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
      <form action="option2.php" method="post">
        <div class="card-group">
          <div class="card">
            <div class="card-body">
              <p class="card-text"> <h2>Basic</h2><br><br>
              <p>Bagages supplementaire</p><br>
              <p>Billet Modifiable</p><br>
              <p>Annulation du billet</p><br>
              <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <input type="radio" name="choix" value="1"/>
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
                <input type="radio" name="choix" value="2"/>
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
              <input type="radio" name="choix" value="3"/>
            </div>
          </p>
        </div>
        <input class="btn btn-primary" type="submit" value="Valider">
      </form>
    </main>
  </body>
</html>