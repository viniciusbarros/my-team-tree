<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace MyTeamTree\Validation;

use Respect\Validation\Validator as RespectValidator;
use Respect\Validation\Exceptions\NestedValidationException;

/**
 * Description of Validator
 *
 * @author vinicius
 */
class Validator
{
    protected $errors = [];

    public function validate($request, array $rules)
    {
        foreach ($rules as $field => $rule) {
            try {
                $rule->setName(ucfirst($field))->assert($request->getParam($field));
            } catch (NestedValidationException $ex) {
                $this->errors[$field] = $ex->getMessages();
            }
        }

        $_SESSION['validationErrors'] = $this->errors;

       return $this;
    }

    public function failed(){
        return !empty($this->errors);
    }

    public function getErrors(){
        return $this->errors;
    }
}