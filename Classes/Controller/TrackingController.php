<?php
namespace Aoe\GoogleTagManager\Controller;

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

use Aoe\GoogleTagManager\Model\DataLayerRegistry;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;
use TYPO3\CMS\Extbase\Mvc\Exception\StopActionException;

class TrackingController extends ActionController
{
    /**
     * index action generate the base tag code
     */
    public function indexAction()
    {
        if (!$this->settings['enable']) {
            throw new StopActionException();
        }
        $this->view->assign('tagManagerID', $this->settings['tagId']);
        $this->view->assign('dataLayerVersion', $this->settings['dataLayerVersion']);
    }

    /**
     * generate the data layer values code
     */
    public function valuesAction()
    {
        if (!$this->settings['enable']) {
            throw new StopActionException();
        }
        /** @var DataLayerRegistry $registry */
        $registry = $this->objectManager->get(DataLayerRegistry::class);
        $this->view->assign('vars', $registry->getVars());
        $registry->clear();
    }
}
