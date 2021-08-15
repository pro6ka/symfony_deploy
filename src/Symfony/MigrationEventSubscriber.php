<?php

namespace App\Symfony;

use Doctrine\Common\EventSubscriber;
use Doctrine\DBAL\Schema\SchemaException;
use Doctrine\ORM\Tools\Event\GenerateSchemaEventArgs;
use Doctrine\ORM\Tools\ToolEvents;

class MigrationEventSubscriber implements EventSubscriber
{
    /**
     * @return string[]
     */
    public function getSubscribedEvents(): array
    {
        return [
//            'postGenerateSchema' => "postGenerateSchema_fun_name",
//            ToolEvents::postGenerateSchema => "postGenerateSchema_fun_name",
            'postGenerateSchema' => 'postGenerateSchema'
            ];
    }

    /**
     * @throws SchemaException
     * postGenerateSchema_fun_name - just for example
     */
//    public function postGenerateSchema_fun_name(GenerateSchemaEventArgs $args): void
    public function postGenerateSchema(GenerateSchemaEventArgs $args): void
    {
        $schema = $args->getSchema();
        if (!$schema->hasNamespace('public')) {
            $schema->createNamespace('public');
        }
    }
}