<?php

class Dataform
{
    private array $data;
    public array $errors;
    public const MAX_PASSENGERS = 12;
    private static ?Dataform $instance = null;


    public function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->data = $data;
        }
    }

    public function getData() :array
    {
        return isset($this->data) ? $this->data : [];
    }

    private function testInput (string $input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }

    private function testData(array $data) :array
    {
        foreach ($data as $key => $value) {
            $value = $this->testInput(isset($data[$key]));
        }

        return $data;
    }

    public static function getInstance($data = array()): Dataform
    {
        if (!self::$instance) {
            self::$instance = new self($data);
        }
        
        return self::$instance;
    }
}