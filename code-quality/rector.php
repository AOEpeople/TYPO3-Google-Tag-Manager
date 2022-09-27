<?php

declare(strict_types=1);

use Rector\Arguments\Rector\FuncCall\FunctionArgumentDefaultValueReplacerRector;
use Rector\Arguments\Rector\FuncCall\SwapFuncCallArgumentsRector;
use Rector\CodeQuality\Rector\Array_\CallableThisArrayToAnonymousFunctionRector;
use Rector\CodeQuality\Rector\If_\ExplicitBoolCompareRector;
use Rector\CodeQualityStrict\Rector\Variable\MoveVariableDeclarationNearReferenceRector;
use Rector\Core\Configuration\Option;
use Rector\DeadCode\Rector\If_\RemoveDeadInstanceOfRector;
use Rector\DeadCode\Rector\Node\RemoveNonExistingVarAnnotationRector;
use Rector\DeadCode\Rector\Property\RemoveUnusedPrivatePropertyRector;
use Rector\DeadCode\Rector\PropertyProperty\RemoveNullPropertyInitializationRector;
use Rector\EarlyReturn\Rector\If_\ChangeAndIfToEarlyReturnRector;
use Rector\EarlyReturn\Rector\If_\ChangeOrIfReturnToEarlyReturnRector;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Php73\Rector\FuncCall\JsonThrowOnErrorRector;
use Rector\Php74\Rector\Closure\ClosureToArrowFunctionRector;
use Rector\Php74\Rector\LNumber\AddLiteralSeparatorToNumberRector;
use Rector\Php74\Rector\Property\TypedPropertyRector;
use Rector\PHPUnit\Rector\MethodCall\RemoveExpectAnyFromMockRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Privatization\Rector\Class_\FinalizeClassesWithoutChildrenRector;
use Rector\Privatization\Rector\Class_\RepeatedLiteralToClassConstantRector;
use Rector\PSR4\Rector\FileWithoutNamespace\NormalizeNamespaceByPSR4ComposerAutoloadRector;
use Rector\Set\ValueObject\SetList;
use Rector\TypeDeclaration\Rector\ClassMethod\ReturnTypeFromStrictTypedCallRector;
use Rector\TypeDeclaration\Rector\Closure\AddClosureReturnTypeRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ParamTypeDeclarationRector;
use Rector\TypeDeclaration\Rector\FunctionLike\ReturnTypeDeclarationRector;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;

return static function (ContainerConfigurator $containerConfigurator): void {
    $containerConfigurator->import(SetList::CODE_QUALITY);
    $containerConfigurator->import(SetList::CODE_QUALITY_STRICT);
    $containerConfigurator->import(SetList::CODING_STYLE);
    $containerConfigurator->import(SetList::DEAD_CODE);
    $containerConfigurator->import(SetList::EARLY_RETURN);
    $containerConfigurator->import(SetList::PRIVATIZATION);
    $containerConfigurator->import(SetList::TYPE_DECLARATION);
    $containerConfigurator->import(SetList::PSR_4);
    $containerConfigurator->import(SetList::MYSQL_TO_MYSQLI);
    $containerConfigurator->import(SetList::TYPE_DECLARATION_STRICT);
    $containerConfigurator->import(SetList::UNWRAP_COMPAT);

    $containerConfigurator->import(SetList::PHP_72);
    $containerConfigurator->import(SetList::PHP_73);
    $containerConfigurator->import(SetList::PHP_74);
    $containerConfigurator->import(SetList::PHP_80);

    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);

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

    $containerConfigurator->import(PHPUnitSetList::PHPUNIT_CODE_QUALITY);

    $parameters->set(Option::AUTO_IMPORT_NAMES, false);
    $parameters->set(Option::AUTOLOAD_PATHS, [__DIR__ . '/../Classes']);
    $parameters->set(
        Option::SKIP,
        [
            FinalizeClassesWithoutChildrenRector::class,
            AddLiteralSeparatorToNumberRector::class,
            ReturnTypeDeclarationRector::class,
            ChangeOrIfReturnToEarlyReturnRector::class,
            ChangeAndIfToEarlyReturnRector::class,
            RepeatedLiteralToClassConstantRector::class,
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
            FunctionArgumentDefaultValueReplacerRector::class => [
                __DIR__ . '/../Classes/ViewHelpers/DataLayerViewHelper.php'
            ],
            JsonThrowOnErrorRector::class => [
                __DIR__ . '/../Classes/ViewHelpers/DataLayerViewHelper.php'
            ],
            RemoveDeadInstanceOfRector::class => [
                __DIR__ . '/../Classes/Model/DataLayerRegistry.php',
            ]
        ]
    );

    $services = $containerConfigurator->services();
    $services->set(RemoveUnusedPrivatePropertyRector::class);
};
