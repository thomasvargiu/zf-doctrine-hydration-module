<?php

namespace Phpro\DoctrineHydrationModule\Hydrator\ODM\MongoDB\Strategy;

use Doctrine\Common\Collections\Collection;

/**
 * Class PersistentCollection.
 */
class ReferencedField extends AbstractMongoStrategy
{
    /**
     * {@inheritDoc}
     */
    public function extract($value, ?object $object = null)
    {
        if (!is_object($value)) {
            return $value;
        }

        $idField = $this->getClassMetadata()->getIdentifier();
        $idField = is_array($idField) ? current($idField) : $idField;
        $getter = 'get'.ucfirst($idField);

        // Validate object:
        $rc = new \ReflectionClass($value);
        if (!$rc->hasMethod($getter)) {
            return $value;
        }

        return $value->$getter();
    }

    /**
     * @param mixed $value
     *
     * @return array|Collection|mixed
     */
    public function hydrate($value, ?array $data)
    {
        if (is_object($value)) {
            return $value;
        }

        $mapping = $this->getClassMetadata()->fieldMappings[$this->getCollectionName()];
        $targetDocument = $mapping['targetDocument'];

        return $this->findTargetDocument($targetDocument, $value);
    }
}
