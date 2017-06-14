<?php
namespace Macfiss\Validation;

class Exception extends \Exception
{
    public function __construct($message, $params = null, $code = 0)
    {
        if($params) {
            $message = str_replace(array_keys($params), array_values($params), $message);
        }
    
        parent::__construct($message, $code);
    }

    public function __toString() {
        return __CLASS__ . ": {$this->message}\n";
    }
}