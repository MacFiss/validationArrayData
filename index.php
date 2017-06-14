<?php
use Macfiss\Validation\Validate;
use Macfiss\Validation\Rules as ValidateRules;

require_once __DIR__ . '/vendor/autoload.php';

$_POST['email_1'] = 'test@test.com'; // it's ok email
$_POST['email_2'] = 'test@testcom'; // it's bad email

//$_POST['noname'] = 'test'; // it's other spam field -- error

$validate = new Validate($_POST, new ValidateRules());

$validate->field('email_1', [ValidateRules::EMAIL, ValidateRules::REQUIRED]);
$validate->field('email_2', ValidateRules::EMAIL);

if($validate->strict(true)) {
    throw new \Exception('Extra fields in post requests');
}

var_dump($validate->isError(), $validate->getErrors(), $validate->getParams());

