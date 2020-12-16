<?php

namespace App\Service;

use JMS\Serializer\SerializationContext;
use JMS\Serializer\SerializerBuilder;

class SerializerService
{
    private $serializer;

    public function __construct()
    {
        $this->serializer = SerializerBuilder::create()->build();
    }

    public function serialize($object, bool $details = false): string
    {
        $groups = ['Default'];
        if ($details) $groups = ['Default', 'details'];
        return $this->serializer->serialize($object, 'json', SerializationContext::create()->setSerializeNull(true)->setGroups($groups));
    }

    public function deserialize(string $serializedObject, string $objectClass)
    {
        return $this->serializer->deserialize($serializedObject, $objectClass, 'json');
    }
}
