<?php
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
use TYPO3\CMS\Extbase\Object\ObjectManager;

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
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    public function setUp()
    {
        parent::setup();
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['google_tag_manager']['variableProviders']['test'] = self::class;
        $this->dataLayerRegistry = new DataLayerRegistry(new ObjectManager());
    }

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    public function tearDown()
    {
        parent::tearDown();
        unset($GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['google_tag_manager']['variableProviders']['test']);
        $this->dataLayerRegistry = null;
    }

    /**
     * @test
     */
    public function shouldAddVar()
    {
        $this->dataLayerRegistry->addVar('test', 'abc');
        $vars = $this->dataLayerRegistry->getVars();
        $this->assertArrayHasKey('test', $vars);
        $this->assertEquals('abc', $vars['test']);
    }

    /**
     * @test
     */
    public function getJSVariables()
    {
        $this->dataLayerRegistry->addVar('test', 'abc');
        $js = $this->dataLayerRegistry->getJSVariables();
        $this->assertContains('dataLayer', $js);
        $this->assertContains('test', $js);
        $this->assertContains('abc', $js);
    }

    /**
     * @test
     */
    public function shouldAddVarsFromHooks()
    {
        $vars = $this->dataLayerRegistry->getVars();
        $this->assertArrayHasKey('foo', $vars);
        $this->assertEquals('bar', $vars['foo']);
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionCode 1459503274
     */
    public function shouldThrowExceptionIfHookClassNotExists()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['google_tag_manager']['variableProviders']['test'] = 'foo';
        $this->dataLayerRegistry->getVars();
    }

    /**
     * @test
     * @expectedException \RuntimeException
     * @expectedExceptionCode 1459503275
     */
    public function shouldThrowExceptionIfHookClassDoesNotImplementInterface()
    {
        $GLOBALS['TYPO3_CONF_VARS']['EXTCONF']['google_tag_manager']['variableProviders']['test'] = DataLayerViewHelper::class;
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
