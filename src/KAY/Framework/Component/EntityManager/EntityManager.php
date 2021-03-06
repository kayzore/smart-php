<?php
namespace KAY\Framework\Component\EntityManager;


class EntityManager extends Entity
{
    /**
     * @param string $entity_path
     * @return EntityManager
     */
    public function get($entity_path)
    {
        $entity = $this->extractEntity($entity_path);
        $this->entity = new $entity();
        return $this;
    }
    /**
     * @param string $entity_path
     * @return EntityManager
     */
    public function getQuery($entity_path)
    {
        $entity = $this->extractEntity($entity_path);
        $entityQuery = $entity . 'Query';
        $this->entity = new $entity();
        $this->entityQuery = new $entityQuery($this->getDatabase());
        return $this;
    }

    /**
     * Validation check
     * @param EntityValidation $entityValidation
     * @param $post
     * @param $errors
     * @return bool
     */
    public function emInsert(EntityValidation $entityValidation, $post, &$errors)
    {
        return $entityValidation->validateField($post, $errors);
    }

    private function extractEntity($path)
    {
        $entity_infos = explode(':', $path);
        return '\\' . $entity_infos[0] . '\Entity\\' . $entity_infos[1];
    }

    private function extractEntityName($entity)
    {
        $entity_infos = explode('\\', get_class($entity));
        return $entity_infos[count($entity_infos) - 1];
    }
}