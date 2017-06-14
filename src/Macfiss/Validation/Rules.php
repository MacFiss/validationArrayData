<?php
namespace Macfiss\Validation;

class Rules implements RulesInterface
{
    const EMAIL = 'email';

    protected $messages = [
        self::REQUIRED => 'Field is required',
        self::EMAIL => 'Invalid e-mail address format'
    ];

    public function validateEmail($value)
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) ? true : false;
    }

    public function validateRequired($value)
    {
        return $value != null ? true : false;
    }

    public function getMessage($type)
    {
        return $this->messages[$type] ?? null;
    }
}