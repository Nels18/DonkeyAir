<?php
    $numberMaxPassengers = 12;
    // Messages
    $failMessage = '';
    $succesMessage = '';
    
    // Checking datas
    function testInput ($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        
        return $input;
    }

    function testData($data)
    {
        foreach ($data as $key => $value) {
            $value = testInput(isset($data[$key]));
        }

        return $data;
    }

    function translateTripClass ($tripClass)
    {
        switch ($tripClass) {
            case 'economy-class':
                $tripClass = "Économique";
                break;
            case 'business-class':
                $tripClass = "Affaire";
                break;
            case 'firts-class':
                $tripClass = "Première";
                break;
            
            default:
            $tripClass = "";
                break;
        }

        return $tripClass;
    }

    function getErrors ($numberMaxPassengers,$failMessage)
    {

        // Inputs values
        $searchCityStart = '';
        $searchCityTo = '';
        $searchDepartureDate = '';
        $searchReturnDate = '';
        $searchTripClass = '';
        $searchTripType = '';
        $searchNumberOfPassenger = '';

        // Inputs errors messages
        $searchCityStartError = '';
        $searchCityToError = '';
        $searchDepartureDateError = '';
        $searchReturnDateError = '';
        $searchTripClassError = '';
        $searchTripTypeError = '';
        $searchNumberOfPassengerError = '';


        if (empty($_GET['city-start'])) {
            $searchCityStartError .= "<p class=\"text-danger\">Une ville de départ est requise.</p>";
            $failMessage .= $searchCityStartError;
        } else {
            $searchCityStart = testInput($_GET['city-start']);
        }
    
        if (empty($_GET['city-to'])) {
            $searchCityToError .= "<p class=\"text-danger\">Une ville d'arrivé est requise.</p>";
            $failMessage .= $searchCityToError;
        } else {
            $searchCityTo = testInput($_GET['city-to']);
        }

        if (empty($_GET['departure-date'])) {
            $searchDepartureDateError .= "<p class=\"text-danger\">Une date de départ est requise.</p>";
            $failMessage .= $searchDepartureDateError;
        } else {
            $searchDepartureDate = testInput($_GET['departure-date']);
        }
    
        if (empty($_GET['return-date']) || (!isset($_GET['trip-type']) && ('round-trip' == isset($_GET['trip-type'])))) {
            $searchReturnDateError .= "<p class=\"text-danger\">Une date de retour est requise.</p>";
            $failMessage .= $searchReturnDateError;
        } else {
            $searchReturnDate = testInput(isset($_GET['return-date']));
        }
    
        if (empty($_GET['trip-class'])) {
            $searchTripClassError .= "<p class=\"text-danger\">Le type de voyage est requis.</p>";
            $failMessage .= $searchTripClassError;
        } else {
            $searchTripClass = testInput($_GET['trip-type']);
        }
    
        if (empty($_GET['trip-type'])) {
            $searchTripTypeError .= "<p class=\"text-danger\">La classe du voyage est requis.</p>";
            $failMessage .= $searchTripTypeError;
        } else {
            $searchTripType = testInput($_GET['trip-class']);
        }
    
        if (empty($_GET['number-of-passenger'])) {
            $searchNumberOfPassengerError .= "<p class=\"text-danger\">Le nombre de passgers est requis.</p>";
            $failMessage .= $searchNumberOfPassengerError;
        } else {
            $searchNumberOfPassenger = testInput($_GET['number-of-passenger']);
            if ($numberMaxPassengers < $searchNumberOfPassenger) {
                $searchNumberOfPassengerError .= "<p class=\"text-danger\">Vous devez choisir un nombre de passagers inférieur à " . $numberMaxPassengers . " ou réserver un voyage de groupe.";
                $failMessage .= $searchNumberOfPassengerError;
            }
        }
        
        return $failMessage;
    }