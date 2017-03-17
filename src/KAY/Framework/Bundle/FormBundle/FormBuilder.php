<?php
namespace KAY\Framework\Bundle\FormBundle;


class FormBuilder
{
    /**
     * @var FormBuilder
     */
    private $builder;
    /**
     * @var $entityName
     */
    private $entityName;
    private $form = array();

    public function add($entity_field, $type_field, array $options)
    {
        $label = '';
        if (isset($options['label'])) {
            $id = $options['attr']['id'];
            $label = '<label ' . (isset($options['label']['class']) ? 'class="' . $options['label']['class'] . '"' : '') .
                ' for="' . $this->getEntityName() . '_' . $id . '">' . $options['label']['text'] . '</label>';
        }
        $attr = $this->checkAttr($entity_field, $options);
        $this->setForm($entity_field, $label . '<input type="' . $type_field .'" name="_' . $entity_field . '"' . $attr .'>');

        return $this;
    }

    private function checkAttr($entity_field, $options)
    {
        $attr = '';
        foreach ($options['attr'] as $key => $option) {
            if ($key == 'class') {
                $attr .= ' class="' . $option . '"';
            } elseif ($key == 'id') {
                $attr .= ' id="' . $this->getEntityName() . '_' . $option . '"';
            } elseif ($key == 'multiple') {
                $attr .= ' multiple="' . $option . '"';
            } elseif ($key == 'placeholder') {
                $attr .= ' placeholder="' . $option . '"';
            }
        }
        return $attr;
    }

    /**
     * @return FormBuilder
     */
    public function getBuilder()
    {
        return $this->builder;
    }

    /**
     * @param FormBuilder $builder
     * @return FormBuilder
     */
    public function setBuilder(FormBuilder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * @return array
     */
    public function getForm()
    {
        return $this->form;
    }

    /**
     * @param $field_name
     * @param string $field
     * @return FormBuilder
     */
    public function setForm($field_name, $field)
    {
        $this->form[$field_name] = $field;

        return $this;
    }

    /**
     * @return string
     */
    public function getEntityName()
    {
        return $this->entityName;
    }

    /**
     * @param string $entityName
     * @return FormBuilder
     */
    public function setEntityName($entityName)
    {
        $this->entityName = $entityName;

        return $this;
    }
}