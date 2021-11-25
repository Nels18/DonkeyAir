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
        if ('' == $this->params[$inputItem] || 0 == $this->params[$inputItem]) {
            // echo '##!key-exists<br>';
            if ('city-start' == $inputItem) {
                $this->errors['city-start'] = "Une ville de départ est requise.";
            }
    
            if ('city-to' == $inputItem) {
                $this->errors['city-to'] = "Une ville d'arrivé est requise.";
            }
    
            if ('departure-date' == $inputItem) {
                $this->errors['departure-date'] = "Une date de départ est requise.";
            }
    
            if ('return-date' == $inputItem) {
                $this->errors['return-date'] = "Une date de retour est requise.";
            }
    
            if ('trip-class' == $inputItem) {
                $this->errors['trip-class'] = "Le type de voyage est requis.";
            }
    
            if ('trip-type' == $inputItem) {
                $this->errors['trip-type'] = "La classe du voyage est requis.";
            }
    
            if ('number-of-passenger' == $inputItem) {
                $this->errors['number-of-passenger'] = "Le nombre de passgers est requis.";
            }
        }
    }

    public function limited(string $inputItem)
    {
        if ('number-of-passenger' == $inputItem && Dataform::MAX_PASSENGERS < $this->params[$inputItem]) {
            $this->errors['too-much'] = 'Vous devez choisir un nombre de passagers inférieur à ' . Dataform::MAX_PASSENGERS . ' ou réserver un voyage de groupe.';
        }
    }

    public function getErrors (array $inputsList) 
    {
        foreach ($inputsList as $inputItem) {
            $this->required($inputItem);
            if ('/group-travel.php' == htmlspecialchars($_SERVER["PHP_SELF"])) {
                $this->limited($inputItem);
            }
        }

        return $this->errors;
    }
}