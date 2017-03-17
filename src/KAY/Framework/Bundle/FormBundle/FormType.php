<?php
namespace KAY\Framework\Bundle\FormBundle;


class FormType
{
    /**
     * @param FormTypeInterface $formType
     * @return mixed
     */
    public function buildForm(FormTypeInterface $formType)
    {
        return $formType->buildForm(new FormBuilder());
    }

    public function createView()
    {

    }
}