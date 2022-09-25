<?php

declare(strict_types=1);

use Aoe\Congstar\Codestyle\EcsConfig;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symplify\EasyCodingStandard\ValueObject\Option;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(
        Option::PATHS,
        [
            __DIR__ . '/../Classes',
            __DIR__ . '/../Tests',
            __DIR__ . '/ecs.php',
        ]
    );

    EcsConfig::importDefaultSets($containerConfigurator);

    EcsConfig::setDefaultConfig($containerConfigurator->services());

    // Skip Rules and Sniffer
    $parameters->set(
        Option::SKIP,
        EcsConfig::mergeWithDefaultSkips(
            [
            ]
        )
    );
};
