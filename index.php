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
        <main>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="col-10 card p-5 m-5 rounded-3">
                        <div class="mb-3">
                            <label for="city-start" class="form-label">De</label>
                            <input type="text" class="form-control" id="city-start" placeholder="Ville de départ" list="city-start-autocomplete-list">
                            <datalist id="city-start-autocomplete-list">
                            </datalist>
                        </div>
                        <div class="mb-3">
                            <label for="city-to" class="form-label">Vers</label>
                            <input type="text" class="form-control" id="city-to" placeholder="Ville de destination" list="city-to-autocomplete-list">
                            <datalist id="city-to-autocomplete-list">
                            </datalist>
                        </div>
                        <div class="row">
                            <div class="col mb-3">
                                <label for="departure_date" class="form-label">Départ le</label>
                                <input type="date" class="form-control" id="departure_date" min="">
                            </div>
                            <div class="col mb-3">
                                <label for="arrival_date" class="form-label">Retour le</label>
                                <input type="date" class="form-control" id="arrival_date" min="">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 col-xl-4 mb-3">
                                <label for="trip-type" class="form-label">Type de voyage</label>
                                <select class="form-select" id="trip-type">
                                    <option value="round-trip" selected>Aller retour</option>
                                    <option value="one-way">Aller simple</option>
                                </select>
                            </div>
                            <div class="col-md-6 col-xl-4 mb-3">
                                <label for="trip-class" class="form-label">Classe</label>
                                <select class="form-select" id="trip-class">
                                    <option value="economy-class" selected>Économie</option>
                                    <option value="business-class">Affaire</option>
                                    <option value="firts-class">Première</option>
                                </select>
                            </div>
                            <div class="col-md col-xl-4 mb-3">
                                <label for="number-of-passenger" class="form-label">Nombre de passagers</label>
                                <input type="number" class="form-control" id="number-of-passenger" placeholder="1" min="1">
                            </div>
                        </div>
                        <div class="row align-self-end">
                            <div class="col">
                                <button type="submit" class="btn btn-primary btn-lg px-5">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    <script src="assets/js/main.js"></script>
    </body>
</html>