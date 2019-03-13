<?php
namespace Aoe\GoogleTagManager\ViewHelpers;

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

use Nimut\TestingFramework\TestCase\UnitTestCase;

class Tx_GoogleTagManager_ViewHelpers_DataLayerViewHelperTest extends UnitTestCase
{
    /**
     * @var DataLayerViewHelper
     */
    private $viewHelper;

    /**
     * @var string
     */
    private $varName = 'varName';

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::setUp()
     */
    protected function setUp()
    {
        $this->viewHelper = new DataLayerViewHelper();
    }

    /**
     * (non-PHPdoc)
     * @see PHPUnit_Framework_TestCase::tearDown()
     */
    protected function tearDown()
    {
        $this->viewHelper = null;
    }

    /**
     * @return array
     */
    public function allDataProvider()
    {
        $sampleObject = new \stdClass();
        $sampleObject->foo = 1;
        $sampleObject->bar = 'baz';
        return [
            [true, $this->createJsCode('true')], // boolean
            [false, $this->createJsCode('false')], // boolean
            [1, $this->createJsCode(1)], // integer
            [0.995, $this->createJsCode(0.995)], // float
            ['foo', $this->createJsCode('\'foo\'')], // string
            [['foo', 'bar'], $this->createJsCode('["foo","bar"]')], // array
            [$sampleObject, $this->createJsCode('{"foo":1,"bar":"baz"}')] // object
        ];
    }

    /**
     * @test
     * @dataProvider allDataProvider
     * @param mixed $value
     * @param mixed $expected
     */
    public function render($value, $expected)
    {
        $this->viewHelper->setArguments(['name' => 'varName', 'value' => $value]);
        $this->assertEquals($expected, $this->viewHelper->render());
    }

    /**
     * @test
     */
    public function renderWithNullValue()
    {
        $this->viewHelper->setArguments(['name' => 'foo', 'value' => null]);
        $this->assertEquals('', $this->viewHelper->render());
    }

    /**
     * @param mixed $value
     * @return string
     */
    private function createJsCode($value)
    {
        return 'dataLayer.push({\'' . $this->varName . '\': ' . $value . '});' . PHP_EOL;
    }
}
