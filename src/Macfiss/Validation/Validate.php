<?php
namespace Macfiss\Validation;

class Validate {
    private $params = [];
    private $errors = [];
    private $rules, $data;

    public function __construct(array $data, Rules $rules)
    {
        $this->data = $data;
        $this->rules = $rules;
    }

    /**
     * Сheck for extra fields
     * @param bool $status
     * @return array
     */
    public function strict($status = true)
    {
        if(!$status) {
            return false;
        }

        $merged = array_merge($this->errors, $this->params);
        return array_diff_key($this->data, $merged);
    }
    
    /**
     * Inserted mask in field
     * @param [string] $fieldName
     * @param [array]  $params
     * @return void
     */
    public function field($fieldName, $params = [])
    {
        $value = $this->getData($fieldName);

        if(!is_array($params)) {
            $params = [$params];
        }

        foreach($params as $type) {
            $status = $this->validation($value, $type) || (!in_array(Rules::REQUIRED, $params) && $value == null) && true;
            
            if($status) {
                $this->params[$fieldName] = $value;
            } else {
                $this->errors[$fieldName] = $type;
            }
        }
    }

    /**
     * Returns a list of fields
     * @return array
     */
    public function getParams() : array
    {
        return $this->params;
    }

    /**
     * Returns a list of fields that are not validated
     * @return array
     */
    public function getErrors() 
    {
        if(!$this->errors) {
            return false;
        }

        $result = $this->errors;

        foreach($result as $fieldName => $type) {
            $result[$fieldName] = $this->rules->getMessage($type);
        }

        return $result;
    }

    /**
     * @return int
     */
    public function isError() : bool
    {
        return count($this->errors) > 0;
    }

    /**
     * Checks the passed value according to the rule [ValidateRules]
     * @param $value
     * @param $type
     * @throws Exception
     * @return bool
     */
    private function validation($value, $type) : bool
    {
        $nameValidate = 'validate' . ucfirst($type);

        if(!method_exists($this->rules, $nameValidate)) {
            throw new Exception('Validation %type method not found', [
                '%type' => $type
            ]);
        }

        return call_user_func([$this->rules, $nameValidate], $value);
    }
    /**
     * Gets the value from the post request
     * @param [type] $name
     * @return string, bool
     */
    private function getData($name)
    {
        return $this->data[$name] ?? null;
    }
}