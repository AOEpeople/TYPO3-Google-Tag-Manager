<?php
use Aoe\GoogleTagManager\Controller\DataLayerController;
use Aoe\GoogleTagManager\Controller\TrackingController;

defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Aoe.google_tag_manager',
    'Tracking',
    [
        TrackingController::class => 'index,values'
    ],
    [
        TrackingController::class => ''
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Aoe.google_tag_manager',
    'DataLayer',
    [
        DataLayerController::class => 'index'
    ]
);
