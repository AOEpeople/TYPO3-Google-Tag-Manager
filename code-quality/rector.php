<?php

declare(strict_types=1);

use Aoe\Congstar\Codestyle\RectorConfig;
use Rector\Arguments\Rector\FuncCall\SwapFuncCallArgumentsRector;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQualityStrict\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromReturnNewRector;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $parameters = $containerConfigurator->parameters();
    $parameters->set(
        Option::PATHS,
        [
            __DIR__ . '/../Classes',
            __DIR__ . '/../Tests',
            __DIR__ . '/rector.php',
            __DIR__ . '/rector-8_0.php',
        ]
    );

    $containerConfigurator = RectorConfig::importDefaultSets($containerConfigurator);

    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);

    $parameters->set(Option::AUTO_IMPORT_NAMES, false);
    $parameters->set(Option::AUTOLOAD_PATHS, [__DIR__ . '/../Classes']);
    $parameters->set(
        Option::SKIP,
        RectorConfig::mergeWithDefaultSkips(
            [
                ReturnTypeDeclarationRector::class,
                TypedPropertyRector::class,
                RemoveNullPropertyInitializationRector::class,
                RenameVariableToMatchMethodCallReturnTypeRector::class,
                ParamTypeDeclarationRector::class,
                ReturnTypeFromStrictTypedCallRector::class,
                SwapFuncCallArgumentsRector::class,
                AddClosureReturnTypeRector::class,
                CallableThisArrayToAnonymousFunctionRector::class,
                ClosureToArrowFunctionRector::class,
                ExplicitBoolCompareRector::class,
                MoveVariableDeclarationNearReferenceRector::class,
                NormalizeNamespaceByPSR4ComposerAutoloadRector::class,
                RemoveNonExistingVarAnnotationRector::class,
                RemoveExpectAnyFromMockRector::class,
                RemoveDeadInstanceOfRector::class => [
                    __DIR__ . '/../Classes/Model/DataLayerRegistry.php',
                ]
            ]
        )
    );

    $services = $containerConfigurator->services();
    $services->set(RemoveUnusedPrivatePropertyRector::class);
};
