<?php
namespace KAY\Framework\Bundle\FormBundle;


interface FormTypeInterface
{
    public function buildForm(FormBuilder $builder);

    public function configureOptions(AbstractForm $abstractForm);

    public function getName();
}