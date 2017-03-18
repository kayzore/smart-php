<?php
namespace KAY\Framework\Component\EntityManager;


class EntityValidation
{
    public function validateField($post, &$errors = [])
    {
        $validation_methods = preg_grep('/^valid_/', get_class_methods($this));
        foreach ($validation_methods as $method) {
            $field_name = '_' . str_replace('valid_', '', $method);
            $msg = '';
            if (!$this->$method($post[$field_name], $msg)) {
                $errors[$field_name] = $msg;
            }
        }
        if (count($errors) > 0) {
            return false;
        }
        return true;
    }
}