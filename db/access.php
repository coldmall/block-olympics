<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [

    /* ----- запись абитуриента ----- */
    'block/olympics:enrol' => [
        'captype'      => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => [ 'user' => CAP_ALLOW ],
    ],

    /* ----- просмотр списка записавшихся ----- */
    'block/olympics:viewenrol' => [
        'captype'      => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => [ 'manager' => CAP_ALLOW ],
    ],

    /* ===== СОЗДАНИЕ / РЕДАКТИРОВАНИЕ ===== */
    'block/olympics:manage' => [
        'captype'      => 'write',
        'riskbitmask'  => RISK_XSS,
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => [
            'manager'    => CAP_ALLOW,
        ],
    ],
];
