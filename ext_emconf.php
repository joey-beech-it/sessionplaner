<?php

/*
 * This file is part of the package evoweb/sessionplaner.
 *
 * For the full copyright and license information, please read the
 * LICENSE file that was distributed with this source code.
 */

$EM_CONF['sessionplaner'] = [
    'title' => 'Session Planer',
    'description' => 'Plan and display sessions for bar camp like events',
    'category' => 'misc',
    'author' => 'Sebastian Fischer, Benjamin Kott',
    'author_email' => 'typo3@evoweb.de, benjamin.kott@outlook.com',
    'author_company' => '',
    'state' => 'stable',
    'clearCacheOnLoad' => 1,
    'version' => '4.2.2',
    'constraints' => [
        'depends' => [
            'typo3' => '11.0.0-11.9.99',
            'form' => '*',
        ],
        'conflicts' => [],
        'suggests' => [],
    ],
];
