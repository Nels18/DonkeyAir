<?php

class ValidatorError
{
    private $key;
    private $rule;
    private $message = [
        'required' => [

        ],
    ];

    public function __construct(string $key, string $rule, string $input = '')
    {
        $this->key = $key;
        $this->rule = $rule;
    }


    

    public function __toString()
    {
        sprintf($this->message[$this->rule], $this->key);
    }
}