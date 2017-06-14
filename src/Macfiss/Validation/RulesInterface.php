<?php
namespace Macfiss\Validation;

interface RulesInterface
{
    const REQUIRED = 'required';
    public function getMessage($type);
}