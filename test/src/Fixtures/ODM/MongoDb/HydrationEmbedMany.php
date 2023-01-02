<?php

namespace PhproTest\DoctrineHydrationModule\Fixtures\ODM\MongoDb;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/** @ODM\EmbeddedDocument */
class HydrationEmbedMany
{
    /** @ODM\Field(type="string") */
    public $name;

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
