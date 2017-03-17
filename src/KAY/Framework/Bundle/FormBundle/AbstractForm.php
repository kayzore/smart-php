<?php
namespace KAY\Framework\Bundle\FormBundle;


abstract class AbstractForm
{
    /**
     * @var $entity
     */
    private $entity;

    private $form = array();

    public function __construct()
    {
        $this->configureOptions($this);
    }

    public function createView()
    {
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

    abstract function configureOptions(AbstractForm $abstractForm);
}