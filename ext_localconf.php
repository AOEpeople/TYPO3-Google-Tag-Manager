<?php

use Aoe\GoogleTagManager\Controller\DataLayerController;
use Aoe\GoogleTagManager\Controller\TrackingController;
use TYPO3\CMS\Extbase\Utility\ExtensionUtility;

defined('TYPO3') or die();

ExtensionUtility::configurePlugin(
    'google_tag_manager',
    'Tracking',
    [
        TrackingController::class => 'index,values'
    ],
    [
        TrackingController::class => ''
    ]
);

ExtensionUtility::configurePlugin(
    'google_tag_manager',
    'DataLayer',
    [
        DataLayerController::class => 'index'
    ]
);
