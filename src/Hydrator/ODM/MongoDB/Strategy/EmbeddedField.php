<?php

namespace Phpro\DoctrineHydrationModule\Hydrator\ODM\MongoDB\Strategy;

use Doctrine\Instantiator\Instantiator;

/**
 * Class PersistentCollection.
 */
class EmbeddedField extends AbstractMongoStrategy
{
    /**
     *{@inheritDoc}
     */
    public function extract($value, ?object $object = null)
    {
        if (! is_object($value)) {
            return $value;
        }
        $hydrator = $this->getDoctrineHydrator();

        return $hydrator->extract($value);
    }

    /**
     *
     * @param mixed $value
     *
     * @return array|mixed
     */
    public function hydrate($value, ?array $data)
    {
        $mapping = $this->getClassMetadata()->fieldMappings[$this->getCollectionName()];
        $targetDocument = $mapping['targetDocument'];

        if (is_object($value)) {
            return $value;
        }

        $instantiator = new Instantiator();
        $object = $instantiator->instantiate($targetDocument);

        $hydrator = $this->getDoctrineHydrator();
        $hydrator->hydrate($value, $object);

        return $object;
    }
}
