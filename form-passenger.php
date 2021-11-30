<?php
    session_start();

    require_once "lib/Validator.php";

    $_SESSION['trip-option'] = $_POST["trip-option"];

    $validatorForm = new Validator($_SESSION);
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
                        <?php for ($i=0; $i < $_SESSION['number-of-passenger']; $i++): ?>
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
                                        if ("Mme" == isset($_SESSION[$titlePassengerNumber]) || empty($_SESSION[$titlePassengerNumber])) {
                                            echo "selected";
                                        };?> >Madame</option>
                                        <option value="M" <?php
                                        if ("M" == isset($_SESSION[$titlePassengerNumber])) {
                                            "selected";  
                                        };?> >Monsieur</option>
                                    </select>
                                </div>
                                <div class="col-md mb-3">
                                    <label for="<?php echo $firstNamePassengerNumber; ?>" class="form-label">Prénom :</label>
                                    <input type="text" class="form-control" id="<?php echo $firstNamePassengerNumber; ?>" name="<?php echo $firstNamePassengerNumber; ?>" value="<?php
                                    if (isset($_SESSION[$firstNamePassengerNumber])) {
                                        echo $_SESSION[$firstNamePassengerNumber];
                                        }
                                    ?>" required>
                                </div>
                                <div class="col-md mb-3" id="return-flight">
                                    <label for="<?php echo $lastNamePassengerNumber; ?>" class="form-label">Nom :</label>
                                    <input type="text" class="form-control" id="<?php echo $lastNamePassengerNumber; ?>" name="<?php echo $lastNamePassengerNumber; ?>" value="<?php 
                                    if (isset($_SESSION[$lastNamePassengerNumber])) {
                                        echo $_SESSION[$lastNamePassengerNumber];
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
