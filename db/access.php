<?php
defined('MOODLE_INTERNAL') || die();

$capabilities = [
    // Уже существующая способность (запись абитуриента).
    'block/olympics:enrol' => [
        'captype'      => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => [
        ],
    ],

    // ⬇ Новая способность — смотреть список записавшихся.
    'block/olympics:viewenrol' => [
        'captype'      => 'read',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => [
            'manager' => CAP_ALLOW,
            // Другие роли можно добавить позже (или оставьте пусто).
        ],
    ],
];
