<?php

namespace App\Service;

class Validator
{
    protected $data;
    protected $errors = [];
    protected $rules = [];
    protected $db;

    public function __construct($data, $db = null)
    {
        $this->data = $data;
        $this->db = $db;
    }

    public function setRules(array $rules)
    {
        $this->rules = $rules;
    }

    public function validate()
    {
        foreach ($this->rules as $field => $rules) {
            $value = $this->data[$field] ?? null;

            foreach (explode('|', $rules) as $rule) {
                $this->runValidationRule($field, $rule, $value);
            }
        }

        return empty($this->errors);
    }

    protected function runValidationRule($field, $rule, $value)
    {

        if ($rule === 'nullable') {
            return;
        }

        if (strpos($rule, ':') !== false) {
            list($ruleName, $parameter) = explode(':', $rule);
        } else {
            $ruleName = $rule;
            $parameter = null;
        }

        if (method_exists($this, $ruleName)) {
            $this->$ruleName($field, $value, $parameter);
        }
    }


    protected function required($field, $value, $parameter)
    {
        if (empty($value)) {
            $this->errors[$field][] = "$field is required.";
        }
    }


    protected function string($field, $value, $parameter)
    {
        if (!is_string($value)) {
            $this->errors[$field][] = "$field must be a string.";
        }
    }


    protected function max($field, $value, $parameter)
    {
        if (strlen($value) > $parameter) {
            $this->errors[$field][] = "$field must not be greater than $parameter characters.";
        }
    }


    protected function min($field, $value, $parameter)
    {
        if (strlen($value) < $parameter) {
            $this->errors[$field][] = "$field must be at least $parameter characters.";
        }
    }


    protected function email($field, $value, $parameter)
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            $this->errors[$field][] = "$field must be a valid email address.";
        }
    }


    protected function unique($field, $value, $parameter)
    {
        if ($this->db && $parameter) {
            list($table, $column) = explode(',', $parameter);


            $where = [$column => $value];
            if (isset($this->data['id'])) {
                $where['id !='] = $this->data['id'];
            }

            $query = "SELECT COUNT(*) FROM $table WHERE $column = :value";
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(':value', $value);
            $stmt->execute();
            $count = $stmt->fetchColumn();

            if ($count > 0) {
                $this->errors[$field][] = "$field must be unique.";
            }
        }
    }


    protected function nullable($field, $value, $parameter)
    {
        if ($value === null || $value === '') {
            return;
        }
    }


    public function errors()
    {
        return $this->errors;
    }
}
