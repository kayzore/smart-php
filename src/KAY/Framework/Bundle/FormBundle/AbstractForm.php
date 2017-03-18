<?php
namespace KAY\Framework\Bundle\FormBundle;


abstract class AbstractForm
{
    /**
     * @var $entity
     */
    private $entity;

    private $form = array();

    private $isValidate = false;

    private $errors = [];

    public function __construct()
    {
        $this->configureOptions($this);
    }

    public function createView()
    {
        if (!empty($this->errors)) {
            $this->form['errors'] = $this->errors;
        }
        return $this->getForm();
    }

    /**
     * @return mixed
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return array
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param array $form
     */
    public function setForm(array $form)
    {
        $this->form = $form;
    }

    public function isValidate()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->isValidate = true;
        }
        return $this->isValidate;
    }

    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    abstract function configureOptions(AbstractForm $abstractForm);
}