<?php
$capabilities = [
    'block/olympics:enrol' => [
        'captype'      => 'write',
        'contextlevel' => CONTEXT_SYSTEM,
        'archetypes'   => [
            'user'   => CAP_ALLOW,      // можно разрешить только роли "Абитуриент"
        ],
    ],
];
