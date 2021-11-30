<?php

require_once("Dataform.php");

class Validator
{
    private array $params;
    protected array $errors = [];

    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function required(string $inputItem)
    {
        $searchFormNotFilledMessage = "Veuillez nous indiquer votre recherche pour commencer";
        if ('' == $this->params[$inputItem]) {
            // echo '##!key-exists<br>';
            if ('city-start' == $inputItem) {
                $this->errors['city-start'] = "Une ville de départ est requise.";
            } elseif (!array_key_exists('city-start',$this->params)) {
                $this->errors['search-form-not-filled'] = $searchFormNotFilledMessage;

            }
    
            if ('city-to' == $inputItem) {
                $this->errors['city-to'] = "Une ville d'arrivé est requise.";
            } elseif (!array_key_exists('city-to',$this->params)) {
                $this->errors['search-form-not-filled'] = $searchFormNotFilledMessage;
            }
    
            if ('departure-date' == $inputItem) {
                $this->errors['departure-date'] = "Une date de départ est requise.";
            } elseif (!array_key_exists('departure-date',$this->params)) {
                $this->errors['search-form-not-filled'] = $searchFormNotFilledMessage;
            }
    
            if ('return-date' == $inputItem) {
                $this->errors['return-date'] = "Une date de retour est requise.";
            } elseif (!array_key_exists('return-date',$this->params)) {
                $this->errors['search-form-not-filled'] = $searchFormNotFilledMessage;
            }
    
            if ('trip-class' == $inputItem) {
                $this->errors['trip-class'] = "Le type de voyage est requis.";
            } elseif (!array_key_exists('trip-class',$this->params)) {
                $this->errors['search-form-not-filled'] = $searchFormNotFilledMessage;
            }
    
            if ('trip-type' == $inputItem) {
                $this->errors['trip-type'] = "La classe du voyage est requis.";
            } elseif (!array_key_exists('trip-type',$this->params)) {
                $this->errors['search-form-not-filled'] = $searchFormNotFilledMessage;
            }
    
            if ('number-of-passenger' == $inputItem) {
                $this->errors['number-of-passenger'] = "Le nombre de passgers est requis.";
            } elseif (!array_key_exists('number-of-passenger',$this->params)) {
                $this->errors['search-form-not-filled'] = $searchFormNotFilledMessage;
            }
        }
    }

    public function limited(string $inputItem)
    {
        if ('number-of-passenger' == $inputItem && Dataform::MAX_PASSENGERS < $this->params[$inputItem]) {
            $this->errors['too-much'] = 'Vous devez choisir un nombre de passagers inférieur à ' . Dataform::MAX_PASSENGERS . ' ou réserver un voyage de groupe.';
        }
    }

    public function mustBeDifferent()
    {
        if (is_null(isset($this->params['city-to'])) || is_null(isset($this->params['city-start']))) {
            if (isset($this->params['city-to']) == isset($this->params['city-start'])) {
                if ($this->params['city-to'] == $this->params['city-start']) {
                    $this->errors['same-airports'] = 'Vous devez choisir un aéroport différent de celui de départ';
                    // echo $this->params;
                }
            }
        }
    }

    
    public function checkDates()
    {
        if (isset($this->params['departure-date']) > isset($this->params['return-date'])) {
            $this->errors['same-airports'] = 'Vous devez choisir une date de retour postérieur à de celle du départ';
        }
    }

    public function getErrors () 
    {   
        foreach (array_keys($this->params) as $inputItem) {
            $this->required($inputItem);
            if ('/group-travel.php' == htmlspecialchars($_SERVER["PHP_SELF"])) {
                $this->limited($inputItem);
            }
        }
        $this->checkDates();
        $this->mustBeDifferent();

        return $this->errors;
    }
}