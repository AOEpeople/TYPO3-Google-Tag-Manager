<?php

declare(strict_types=1);

namespace Aoe\GoogleTagManager\Model;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2018 AOE GmbH <dev@aoe.com>
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/

use Aoe\GoogleTagManager\Service\VariableProviderInterface;
use Aoe\GoogleTagManager\ViewHelpers\DataLayerViewHelper;
use Nimut\TestingFramework\TestCase\FunctionalTestCase;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class DataLayerRegistryTest extends FunctionalTestCase implements VariableProviderInterface
{
    /**
     * @var array
     */
    protected $testExtensionsToLoad = ['typo3conf/ext/google_tag_manager'];

    /**
     * @var DataLayerRegistry
     */
    private $dataLayerRegistry;

    /**
     * (non-PHPdoc)
     *
     * @see PHPUnit_Framework_TestCase::setUp()
     */

    protected function setUp(): void
    {
        parent::setup();
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['google_tag_manager']['variableProviders']['test'] = self::class;
        $this->dataLayerRegistry = GeneralUtility::makeInstance(DataLayerRegistry::class);
    }

    /**
     * (non-PHPdoc)
     *
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown(): void
    {
        parent::tearDown();
        unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['google_tag_manager']['variableProviders']['test']);
        unset($this->dataLayerRegistry);
    }

    public function testShouldAddVar()
    {
        $this->dataLayerRegistry->addVar('test', 'abc');
        $vars = $this->dataLayerRegistry->getVars();
        $this->assertArrayHasKey('test', $vars);
        $this->assertSame('abc', $vars['test']);
    }

    public function testGetJSVariables()
    {
        $this->dataLayerRegistry->addVar('test', 'abc');
        $js = $this->dataLayerRegistry->getJSVariables();
        $this->assertStringContainsString('dataLayer', $js);
        $this->assertStringContainsString('test', $js);
        $this->assertStringContainsString('abc', $js);
    }

    public function testShouldAddVarsFromHooks()
    {
        $vars = $this->dataLayerRegistry->getVars();
        $this->assertArrayHasKey('foo', $vars);
        $this->assertSame('bar', $vars['foo']);
    }

    public function testShouldThrowExceptionIfHookClassNotExists()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(1459503274);

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['google_tag_manager']['variableProviders']['test'] = 'foo';
        $this->dataLayerRegistry->getVars();
    }

    public function testShouldThrowExceptionIfHookClassDoesNotImplementInterface()
    {
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionCode(1459503275);

        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['google_tag_manager']['variableProviders']['test'] =
            DataLayerViewHelper::class;
        $this->dataLayerRegistry->getVars();
    }

    /**
     * @return array
     */
    public function getVariables()
    {
        return ['foo' => 'bar'];
    }
}
