<?php

class Dataform
{
    private array $data;
    public array $errors;
    public const MAX_PASSENGERS = 12;
    private static ?Dataform $instance = null;


    public function __construct($data = array())
    {
        $this->data = $data;
    }

    public function getValue(string $index)
    {
        return isset($this->data[$index]) ? $this->data[$index] : '';
    }

    private function testInput (string $input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        
        return $input;
    }

    public function testData(array $data) :array
    {
        foreach ($data as $key => $value) {
            $value = $this->testInput(isset($data[$key]));
        }

        return $data;
    }

    static function translateTripClass (string $tripClass)
    {
        switch ($tripClass) {
            case 'economy-class':
                $tripClass = "Économique";
                break;
            case 'business-class':
                $tripClass = "Affaire";
                break;
            case 'first-class':
                $tripClass = "Première";
                break;
            
            default:
            $tripClass = "";
                break;
        }

        return $tripClass;
    }

    public static function getInstance($data = array()): Dataform
    {
        if (!self::$instance) {
            self::$instance = new self($data);
        }
        
        return self::$instance;
    }
}