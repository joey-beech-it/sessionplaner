<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

call_user_func(function () {
    // Register "sessionplannervh" as global fluid namespace
    $GLOBALS['TYPO3_CONF_VARS']['SYS']['fluid']['namespaces']['sessionplanervh'][] =
        'Evoweb\\Sessionplaner\\ViewHelpers';

    /**
     * Register Icons
     *
     * @var \TYPO3\CMS\Core\Imaging\IconRegistry $iconRegistry
     */
    $iconRegistry = \TYPO3\CMS\Core\Utility\GeneralUtility::makeInstance(\TYPO3\CMS\Core\Imaging\IconRegistry::class);
    $icons = [
        'plugin-display',
        'plugin-session',
        'plugin-suggest',
        'plugin-speaker',
        'record-day',
        'record-room',
        'record-session',
        'record-slot',
        'record-tag',
        'record-speaker',
    ];
    foreach ($icons as $icon) {
        $iconRegistry->registerIcon(
            'sessionplaner-' . $icon,
            \TYPO3\CMS\Core\Imaging\IconProvider\SvgIconProvider::class,
            ['source' => 'EXT:sessionplaner/Resources/Public/Icons/' . $icon . '.svg']
        );
    }

    /**
     * Add default PageTsConfig
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addPageTSConfig(
        '@import \'EXT:sessionplaner/Configuration/PageTS/ModWizards.tsconfig\''
    );

    /**
     * Register Update Wizards
     */
    $GLOBALS['TYPO3_CONF_VARS']['SC_OPTIONS']['ext/install']['update'][
        \Evoweb\Sessionplaner\Updates\SessionPathSegmentUpdate::class
    ] = \Evoweb\Sessionplaner\Updates\SessionPathSegmentUpdate::class;

    /**
     * Configure Session Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sessionplaner',
        'Session',
        [
            \Evoweb\Sessionplaner\Controller\SessionController::class => 'list, show',
        ]
    );

    /**
     * Configure Sessionplan Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sessionplaner',
        'Sessionplan',
        [
            \Evoweb\Sessionplaner\Controller\SessionplanController::class => 'display',
        ]
    );

    /**
     * Configure Speaker Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sessionplaner',
        'Speaker',
        [
            \Evoweb\Sessionplaner\Controller\SpeakerController::class => 'list, show',
        ]
    );

    /**
     * Configure Speaker Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sessionplaner',
        'Featuredspeaker',
        [
            \Evoweb\Sessionplaner\Controller\SpeakerController::class => 'listFeatured, show',
        ]
    );

    /**
     * Configure Suggest Frontend Plugin
     */
    \TYPO3\CMS\Extbase\Utility\ExtensionUtility::configurePlugin(
        'Sessionplaner',
        'Suggest',
        [
            \Evoweb\Sessionplaner\Controller\SuggestController::class => 'form',
        ],
        [
            \Evoweb\Sessionplaner\Controller\SuggestController::class => 'form',
        ]
    );

    /**
     * Register Title Provider
     */
    \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::addTypoScriptSetup(
        trim(
            '
    config.pageTitleProviders {
        event {
            provider = Evoweb\Sessionplaner\TitleTagProvider\EventTitleTagProvider
            before = seo
            after = altPageTitle
        }
        speaker {
            provider = Evoweb\Sessionplaner\TitleTagProvider\SpeakerTitleTagProvider
            before = seo
            after = altPageTitle
        }
    }
'
        )
    );
});
