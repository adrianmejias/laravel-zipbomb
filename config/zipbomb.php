<?php

/**
 * Laravel Zip Bomb Configuration.
 *
 * Check for nikto, sql map or "bad" subfolders which only exist on
 * WordPress.
 */

return [

    /*
     * User-Agents to check against.
     */
    'agents' => [
        'nikto',
        'sqlmap',
    ],

    /*
     * Paths to check against.
     */
    'paths' => [
        'wp-',
        'wordpress',
        'wp/*',
    ],

    /*
     * Path to the zip bomb file.
     */
    'zip_bomb_file' => storage_path('app/zipbomb/10G.gzip'),

];
