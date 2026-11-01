<?php
/*
 * Configuration example only: copy to config.private.php for personal settings.
 * Never place real credentials in this example or commit the private configuration.
 */
// Copy to config.private.php ONLY if overriding local defaults or configuring Titan.
// config.private.php is ignored by Git. Fill it in privately on each server.
return [
    'local' => [
        'host' => '127.0.0.1',
        'port' => 3306,
        'user' => 'root',
        'password' => '',
        'database' => 'bookverse_a3',
    ],
    'live' => [
        'host' => 'talsprddb02.int.its.rmit.edu.au',
        'port' => 3306,
        'user' => '',     // Exact case-sensitive SDAMDS username.
        'password' => '', // Selected database password, NOT your RMIT password.
        'database' => '', // Exact SDAMDS database name INCLUDING its suffix.
    ],
];
