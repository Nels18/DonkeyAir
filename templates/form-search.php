<?php
session_start();

require_once("lib/Dataform.php");
$data = Dataform::getInstance()->getData();
var_dump($_SESSION);
// var_dump($data);
if (!empty($data)) {
    $valuesForm = [
        'city-start' => $data['city-start'],
        'city-to' => $data['city-to'],
        'departure-date' => $data['departure-date'],
        'return-date' => $data['return-date'],
        'trip-class' => $data['trip-class'],
        'trip-type' => $data['trip-type'],
        'number-of-passenger' => $data['number-of-passenger'],
    ];
    var_dump($valuesForm);
}


if ('/group-travel.php' == htmlspecialchars($_SERVER["PHP_SELF"])):
;?>
<form class="form-search" action="group-travel-confirmation.php" method="post">
<?php else: ;?>
<form class="form-search" action="to-book.php" method="post">
<?php endif ;?>
    <div class="mb-3">
        <label for="city-start" class="form-label">De</label>
        <input type="text" class="form-control" id="city-start" placeholder="Ville de départ" list="city-start-autocomplete-list" name="city-start" value="<?php
        if (isset($valuesForm['city-start'])) {
            echo $valuesForm['city-start'];
        }?>" required>
        <datalist id="city-start-autocomplete-list">
        </datalist>
    </div>
    <div class="mb-3">
        <label for="city-to" class="form-label">Vers</label>
        <input type="text" class="form-control" id="city-to" placeholder="Ville de destination" list="city-to-autocomplete-list" name="city-to" value="<?php
        if (isset($valuesForm['city-to'])) {
            echo $valuesForm['city-to'];
        }?>" required>
        <datalist id="city-to-autocomplete-list">
        </datalist>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="departure-date" class="form-label">Départ le </label>
            <input type="date" class="form-control" id="departure-date" name="departure-date" min="<?= $now->format('Y-m-d') ; ?>" value="<?php
            if (isset($valuesForm['departure-date'])) {
                echo $valuesForm['departure-date'];
                }
            ?>" required>
        </div>
        <div class="col mb-3" id="return-flight">
            <label for="return-date" class="form-label">Retour le</label>
            <input type="date" class="form-control" id="return-date" name="return-date" min="<?php 
            if (isset($valuesForm['return-date'])) {
                echo $valuesForm['return-date'];
            };?>" required>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4 mb-3">
            <label for="trip-type" class="form-label">Type de voyage</label>
            <select class="form-select" id="trip-type" name="trip-type">
                <option value="round-trip" <?php 
                if ("round-trip" == isset($valuesForm['trip-type']) || empty($valuesForm['trip-type'])) {
                    echo "selected";
                };?> >Aller retour</option>
                <option value="one-way" <?php
                if ("one-way" == isset($valuesForm['trip-type'])) {
                    "selected";  
                };?> >Aller simple</option>
            </select>
        </div>
        <div class="col-md-6 col-xl-4 mb-3">
            <label for="trip-class" class="form-label">Classe</label>
            <select class="form-select" id="trip-class" name="trip-class">
                <option value="Économique" <?php
                if ("Économique" == isset($valuesForm['trip-class']) || empty($valuesForm['trip-class'])) {
                    echo "selected";
                };?> ><?php echo 'Économique'; ?></option>

                <option value="business-class" <?php
                if ("Affaire" == isset($valuesForm['trip-class'])) {
                    "selected";
                };?> ><?php echo 'Affaire'; ?></option>

                <option value="Première" <?php 
                if ("Première" == isset($valuesForm['trip-class'])) {
                    "Première";
                };?> ><?php echo 'Premières'; ?></option>
            </select>
        </div>
        <div class="col-md col-xl-4 mb-3">
            <label for="number-of-passenger" class="form-label">Nombre de passagers</label>
            <input type="number" class="form-control" id="number-of-passenger" name="number-of-passenger" 
                <?php
                    if ('/group-travel.php' == htmlspecialchars($_SERVER["PHP_SELF"])) {
                        echo "min=\"13\"";
                    } else {
                        echo "min=\"1\"";
                    }

                    if ('/index.php' == htmlspecialchars($_SERVER["PHP_SELF"])) {
                        echo "max=\"12\" value=\"" . isset($valuesForm['number-of-passenger']) . "\"";
                    }?>
            required >
    </div>
    <?php if('/group-travel.php' == htmlspecialchars($_SERVER["PHP_SELF"])): ?>
    <div class="row justify-content-end">
        <div class="col-md-6 col-xl-4 mb-3 d-grid">
            <button type="submit" class="btn btn-primary btn-lg px-5 my-3">Confirmer</button>
        </div>
    </div>
    <?php else: ?>
        <div >
            <p class="text-primary">Vous souhaitez voyager avec un groupe de plus de <?= Dataform::MAX_PASSENGERS; ?> personnes ? Pas de soucis ! C’est rapide et simple de réserver un voyage de groupe avec DonkeyAir.</p>
        </div>
        <div class="row justify-content-between">
            <div class="col-md-6 col-xl-4 mb-3 d-grid">
                <a href="group-travel.php" class="btn btn-outline-primary btn-lg px-5 my-3">Demander un devis</a>
            </div>
            <div class="col-md-6 col-xl-4 mb-3 d-grid">
                <button type="submit" class="btn btn-primary btn-lg px-5 my-3">Rechercher les vols</button>
            </div>
        </div>
    <?php endif ?>
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
</form>
