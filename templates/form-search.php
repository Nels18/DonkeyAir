<?php if ('/group-travel.php' == htmlspecialchars($_SERVER["PHP_SELF"])): ;?>
<form action="group-travel-confirmation.php" method="get">
<!-- <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get"> -->
<?php else: ;?>
<form action="group-travel-confirmation.php" method="get">
<!-- <form action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="get"> -->
<?php endif ;?>
    <div class="mb-3">
        <label for="city-start" class="form-label">De</label>
        <input type="text" class="form-control" id="city-start" placeholder="Ville de départ" list="city-start-autocomplete-list" name="city-start" value="<?php
        if (isset($_GET['city-start'])) {
            echo $_GET['city-start'];
        }?>">
        <datalist id="city-start-autocomplete-list">
        </datalist>
    </div>
    <div class="mb-3">
        <label for="city-to" class="form-label">Vers</label>
        <input type="text" class="form-control" id="city-to" placeholder="Ville de destination" list="city-to-autocomplete-list" name="city-to" value="<?php
        if (isset($_GET['city-to'])) {
            echo $_GET['city-to'];
        }?>">
        <datalist id="city-to-autocomplete-list">
        </datalist>
    </div>
    <div class="row">
        <div class="col mb-3">
            <label for="departure-date" class="form-label">Départ le </label>
            <div class="flatpickr">
                <input class="" type="text" placeholder="Select Date.." data-input> <!-- input is mandatory -->

                <a class="input-button" title="toggle" data-toggle>
                    <i class="icon-calendar"></i>
                </a>

                <a class="input-button" title="clear" data-clear>
                    <i class="icon-close"></i>
                </a>
            </div>
            <input type="date" class="form-control" id="departure-date" name="departure-date" min="<?= $now->format('Y-m-d') ; ?>" value="<?php
            if (isset($_GET['departure-date'])) {
                echo $_GET['departure-date'];
                }
            ?>">
        </div>
        <div class="col mb-3" id="return-flight">
            <label for="return-date" class="form-label">Retour le</label>
            <input type="date" class="form-control" id="return-date" name="return-date" min="<?php 
            if (isset($_GET['return-date'])) {
                echo $_GET['return-date'];
            };?>">
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xl-4 mb-3">
            <label for="trip-type" class="form-label">Type de voyage</label>
            <select class="form-select" id="trip-type" name="trip-type">
                <option value="round-trip" <?php 
                if ("round-trip" == isset($_GET['trip-type']) || empty($_GET['trip-type'])) {
                    echo "selected";
                };?> >Aller retour</option>
                <option value="one-way" <?php
                if ("one-way" == isset($_GET['trip-type'])) {
                    "selected";  
                };?> >Aller simple</option>
            </select>
        </div>
        <div class="col-md-6 col-xl-4 mb-3">
            <label for="trip-class" class="form-label">Classe</label>
            <select class="form-select" id="trip-class" name="trip-class">
                <option value="economy-class" <?php
                if ("economy-class" == isset($_GET['trip-class']) || empty($_GET['trip-class'])) {
                    echo "selected";
                };?> >Économique</option>
                <option value="business-class" <?php
                if ("business-class" == isset($_GET['trip-class'])) {
                    "selected";
                };?> >Affaire</option>
                <option value="firts-class" <?php 
                if ("firts-class" == isset($_GET['trip-class'])) {
                    "selected";
                };?> >Première</option>
            </select>
        </div>
        <div class="col-md col-xl-4 mb-3">
            <label for="number-of-passenger" class="form-label">Nombre de passagers</label>
            <input type="number" class="form-control" id="number-of-passenger" name="number-of-passenger" min="<?php if ('/group-travel.php' == htmlspecialchars($_SERVER["PHP_SELF"])) {
                echo 13;
            } else {
                echo 1; 
            }?>"
            <?php if ('/index.php' == htmlspecialchars($_SERVER["PHP_SELF"])) {
                echo "max=\"12\"";
            }; ?>
            <?php if (isset($_GET['number-of-passenger'])) {
                echo "value=\"" . $_GET['number-of-passenger'] . "\"";
            };?> >
        </div>
    </div>
    <?php if('/group-travel.php' == htmlspecialchars($_SERVER["PHP_SELF"])): ?>
    <div class="row justify-content-end">
        <div class="col-md-6 col-xl-4 mb-3 d-grid">
            <button type="submit" class="btn btn-primary btn-lg px-5 my-3">confirmer</button>
        </div>
    </div>
    <?php else: ?>
        <div >
            <p class="text-primary">Vous souhaitez voyager avec un groupe de plus de <?= $numberMaxPassengers; ?> personnes ? Pas de soucis ! C’est rapide et simple de réserver un voyage de groupe avec DonkeyAir.</p>
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
    <?php
        // var_dump($_GET['fail-message']);
        // var_dump($_GET);

    ?>
</form>
