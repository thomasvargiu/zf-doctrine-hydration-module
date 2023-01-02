<?php

namespace Phpro\DoctrineHydrationModule\Hydrator\ODM\MongoDB\Strategy;

use Doctrine\Laminas\Hydrator\Strategy\CollectionStrategyInterface;
use Doctrine\Persistence\Mapping\ClassMetadata;
use Doctrine\Persistence\ObjectManager;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use DoctrineModule\Persistence\ProvidesObjectManager;
use Doctrine\Laminas\Hydrator\Strategy\AllowRemoveByValue;
use Phpro\DoctrineHydrationModule\Hydrator\ODM\MongoDB\DoctrineObject;

/**
 * Abstract AbstractMongoStrategy.
 */
abstract class AbstractMongoStrategy implements ObjectManagerAwareInterface, CollectionStrategyInterface
{
    use ProvidesObjectManager;
    private ?ClassMetadata $metadata = null;

    private ?object $object = null;

    private ?string $collectionName = null;

    public function __construct(?ObjectManager $objectManager = null)
    {
        if ($objectManager) {
            $this->setObjectManager($objectManager);
        }
    }

    protected function getDoctrineHydrator(): DoctrineObject
    {
        return new DoctrineObject($this->getObjectManager());
    }

    public function setCollectionName(string $collectionName): void
    {
        $this->collectionName = $collectionName;
    }

    public function getCollectionName(): string
    {
        if ($this->collectionName === null) {
            throw new LogicException('Collection name has not been set.');
        }

        return $this->collectionName;
    }

    public function setClassMetadata(ClassMetadata $classMetadata): void
    {
        $this->metadata = $classMetadata;
    }

    public function getClassMetadata(): ClassMetadata
    {
        if ($this->metadata === null) {
            throw new \LogicException('Class metadata has not been set.');
        }

        return $this->metadata;
    }

    public function setObject(object $object): void
    {
        $this->object = $object;
    }

    public function getObject(): object
    {
        if ($this->object === null) {
            throw new LogicException('Object has not been set.');
        }

        return $this->object;
    }

    /**
     * Use default collection strategy.
     *
     * @param $value
     *
     * @return array|mixed
     */
    protected function hydrateCollection($value)
    {
        $strategy = new AllowRemoveByValue();
        $strategy->setObject($this->object);
        $strategy->setClassMetadata($this->getClassMetadata());
        $strategy->setCollectionName($this->getCollectionName());

        return $strategy->hydrate($value, null);
    }

    /**
     * @param string|class-string $targetDocument
     * @param string $targetId
     *
     * @return object
     */
    protected function findTargetDocument($targetDocument, $targetId)
    {
        $repo = $this->getObjectManager()->getRepository($targetDocument);
        return $repo->find($targetId);
    }
}
