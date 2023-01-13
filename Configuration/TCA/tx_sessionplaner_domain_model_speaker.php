<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

defined('TYPO3') or die();

$languageFile = 'LLL:EXT:sessionplaner/Resources/Private/Language/locallang_tca.xlf:';

\TYPO3\CMS\Core\Utility\ExtensionManagementUtility::allowTableOnStandardPages('tx_sessionplaner_domain_model_speaker');

return [
    'ctrl' => [
        'title' => $languageFile . 'tx_sessionplaner_domain_model_speaker',
        'label' => 'name',
        'tstamp' => 'tstamp',
        'crdate' => 'crdate',
        'default_sortby' => 'ORDER BY name',
        'delete' => 'deleted',
        'enablecolumns' => [
            'disabled' => 'hidden',
        ],
        'typeicon_classes' => [
            'default' => 'sessionplaner-record-speaker'
        ],
    ],
    'columns' => [
        'hidden' => [
            'exclude' => false,
            'label' => 'LLL:EXT:core/Resources/Private/Language/locallang_general.xlf:LGL.hidden',
            'config' => [
                'type' => 'check',
            ],
        ],
        'name' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-name',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim,required',
                'max' => 256,
            ],
        ],
        'featured' => [
            'exclude' => 1,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-featured',
            'config' => [
                'type' => 'check',
                'items' => [
                    ['', 'featured'],
                ],
            ]
        ],
        'path_segment' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-path_segment',
            'config' => [
                'type' => 'slug',
                'generatorOptions' => [
                    'fields' => ['name'],
                    'replacements' => [
                        '/' => ''
                    ],
                ],
                'fallbackCharacter' => '-',
                'eval' => 'uniqueInSite',
                'default' => ''
            ]
        ],
        'company' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-company',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'picture' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-picture',
            'config' => \TYPO3\CMS\Core\Utility\ExtensionManagementUtility::getFileFieldTCAConfig(
                'picture',
                ['maxitems' => 1],
                $GLOBALS['TYPO3_CONF_VARS']['GFX']['imagefile_ext']
            ),
        ],
        'website' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-website',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'twitter' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-twitter',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'linkedin' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-linkedin',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'xing' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-xing',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'email' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-email',
            'config' => [
                'type' => 'input',
                'size' => 20,
                'eval' => 'trim',
                'max' => 256,
            ],
        ],
        'sessions' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-sessions',
            'config' => [
                'type' => 'select',
                'renderType' => 'selectMultipleSideBySide',
                'multiple' => 0,
                'foreign_table' => 'tx_sessionplaner_domain_model_session',
                'foreign_table_where' => 'AND tx_sessionplaner_domain_model_session.pid = ###CURRENT_PID###',
                'MM' => 'tx_sessionplaner_session_speaker_mm',
                'MM_opposite_field' => 'speakers',
            ],
        ],
        'detail_page' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-detail_page',
            'config' => [
                'type' => 'group',
                'size' => 1,
                'default' => 0,
                'minitems' => 0,
                'maxitems' => 1,
                'internal_type' => 'db',
                'allowed' => 'pages'
            ]
        ],
        'bio' => [
            'exclude' => false,
            'label' => $languageFile . 'tx_sessionplaner_domain_model_speaker-bio',
            'config' => [
                'type' => 'text',
                'cols' => '80',
                'rows' => '15',
                'softref' => 'typolink_tag,images,email[subst],url',
                'enableRichtext' => true,
                'richtextConfiguration' => 'default'
            ],
        ],
    ],
    'types' => [
        '0' => [
            'showitem' => '
                hidden,
                name,
                featured,
                path_segment,
                company,
                bio,
                picture,
                website,
                twitter,
                linkedin,
                xing,
                email,
                detail_page,
                sessions,
            '
        ]
    ],
];
