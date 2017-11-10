<?php

declare(strict_types=1);

namespace UMA\DoctrineDemo\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Doctrine\ORM\Tools\Setup;
use Pimple\Container;
use Pimple\ServiceProviderInterface;
use Symfony\Component\Console\Helper\HelperSet;

class Doctrine implements ServiceProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public function register(Container $cnt)
    {
        $cnt['db'] = function (): array {
            return [
                'driver' => 'pdo_sqlite',
                'path' => APP_ROOT . '/var/database.sqlite'
            ];
        };

        $cnt[EntityManager::class] = function (Container $cnt): EntityManager {
            $paths = [APP_ROOT . '/src/Domain'];

            $config = Setup::createAnnotationMetadataConfiguration($paths, true);
            $config->setMetadataDriverImpl(
                new AnnotationDriver(new AnnotationReader, $paths)
            );

            return EntityManager::create($cnt['db'], $config);
        };

        $cnt[HelperSet::class] = function (Container $cnt): HelperSet {
            return ConsoleRunner::createHelperSet($cnt[EntityManager::class]);
        };
    }
}
