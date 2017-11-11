<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Cache\FilesystemCache;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * A ServiceProvider for registering services related to
 * Doctrine in a DI container.
 *
 * If the project had custom repositories (e.g. UserRepository)
 * they could be registered here.
 */
class Doctrine implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $cnt)
    {
        $cnt[EntityManager::class] = function (Container $cnt): EntityManager {
            $config = Setup::createAnnotationMetadataConfiguration(
                $cnt['settings']['doctrine']['metadata_dirs'],
                $cnt['settings']['doctrine']['dev_mode']
            );

            $config->setMetadataDriverImpl(
                new AnnotationDriver(
                    new AnnotationReader,
                    $cnt['settings']['doctrine']['metadata_dirs']
                )
            );

            $config->setMetadataCacheImpl(
                new FilesystemCache(
                    $cnt['settings']['doctrine']['cache_dir']
                )
            );

            return EntityManager::create(
                $cnt['settings']['doctrine']['connection'],
                $config
            );
        };
    }
}
