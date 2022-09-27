<?php
defined('TYPO3') or die();

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Aoe.google_tag_manager',
    'Tracking',
    [
        'Tracking' => 'index,values'
    ],
    [
        'Tracking' => ''
    ]
);

\TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
    'Aoe.google_tag_manager',
    'DataLayer',
    [
        'DataLayer' => 'index'
    ]
);
