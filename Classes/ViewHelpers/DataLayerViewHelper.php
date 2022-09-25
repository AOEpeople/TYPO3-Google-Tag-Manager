<?php

declare(strict_types=1);

namespace Aoe\GoogleTagManager\ViewHelpers;

/***************************************************************
 *  Copyright notice
 *
 *  (c) 2016 AOE GmbH <dev@aoe.com>
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

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class DataLayerViewHelper extends AbstractViewHelper
{
    /**
     * @var boolean
     */
    protected $escapeOutput = false;

    /**
     * Initialize arguments
     */
    public function initializeArguments()
    {
        parent::initializeArguments();
        $this->registerArgument('name', 'string', 'name', true);
        $this->registerArgument('value', 'string', 'value', true);
    }

    /**
     * @return string
     */
    public function render()
    {
        $name = $this->arguments['name'];
        $value = $this->arguments['value'];

        if ($value === null) {
            return '';
        }
        if (is_array($value) || is_object($value)) {
            return "dataLayer.push({'" . $name . "': " . json_encode($value) . '});' . PHP_EOL;
        }
        if (is_string($value)) {
            return "dataLayer.push({'" . $name . "': '" . $value . "'});" . PHP_EOL;
        }
        if (is_bool($value)) {
            $val = 'false';
            if ($value) {
                $val = 'true';
            }
            return "dataLayer.push({'" . $name . "': " . $val . '});' . PHP_EOL;
        }
        return "dataLayer.push({'" . $name . "': " . $value . '});' . PHP_EOL;
    }
}
