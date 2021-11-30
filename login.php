<!--div class="card p-5 m-5 rounded-3" >
  <?php
    require_once "lib/Database.php";
    
    $email = $_POST['email'];
    $password = $_POST['password0'];
    $sha_Password = SHA1($password);
    $error = "";
    
    $request = " SELECT * from customer where password = '".$sha_Password."' and email = '".$email."' ";
    $database = Database::getInstance();
    $result = $database->query($request);
    //var_dump($result);
    if (isset($_POST['submit'])) {
      if ($email == $result[0]["email"] && (SHA1($password) == $result[0]["password"])) 
      {

        $error = "";
        $success = "Bonjour, vous êtes bien connecté !";
        header("Location:index.php?success=".$success);
      }
      else{
            $error = "Votre email ou mot de passe est invalide !";
            $success = "";
      }
    }
    
   
  ?>
  </div-->

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
                    <h2 class="text-center">Connexion</h2>
                    <p class="<?php if ($error !== "") {
                                       echo "alert alert-warning text-center";
                                     } else {
                                       echo "";
                                     }
                                 ?>">
                      <?php echo $error; ?>
                    </p>
                    <form action="login.php" method="post">
                      <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Adresse Mail</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="email">
                        <div id="emailHelp" class="form-text">Vos données sont bien protégées !</div>
                      </div>
                      <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Mot de passe </label>
                        <input type="password" class="form-control" id="exampleInputPassword1" name="password0">
                        <i class="far fa-eye-slash" id="hide" onclick="myFunction()"></i>
                        <i class="far fa-eye" id="show" onclick="myFunction()"></i>

                      </div>
                      <button type="submit" class="btn btn-primary" name="submit">Connexion</button>
                    </form>
                    
                </div>
            </div>
        </main>
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css" integrity="sha384-B4dIYHKNBt8Bc12p+WXckhzcICo0wtJAoU8YZTY5qE0Id1GSseTk6S+L3BlXeVIU" crossorigin="anonymous">
    <script src="assets/js/main.js"></script>
    </body>
   
</html>

