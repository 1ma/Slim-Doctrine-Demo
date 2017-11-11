<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Doctrine implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $cnt)
    {
        $cnt[EntityManager::class] = function (Container $cnt): EntityManager {
            $config = Setup::createAnnotationMetadataConfiguration(
                $cnt['settings']['doctrine']['paths'], true
            );

            $config->setMetadataDriverImpl(
                new AnnotationDriver(
                    new AnnotationReader,
                    $cnt['settings']['doctrine']['paths']
                )
            );

            return EntityManager::create(
                $cnt['settings']['doctrine']['conn'], $config
            );
        };
    }
}
