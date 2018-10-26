<?php
if (!defined('TYPO3_MODE')) {
    die('Access denied.');
}

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
