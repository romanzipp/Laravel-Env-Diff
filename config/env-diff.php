<?php

return [
    /*
     * Specify all environment files that should be compared.
     */
    'files' => [
        '.env',
        '.env.example',
    ],

    /*
     * The base path to look for environment files.
     */
    'path' => base_path(),

    /*
     * User colors when printing console output.
     */
    'use_colors' => true,

    /*
     * Hide variables that exist in all .env files.
     */
    'hide_existing' => true,

    /*
     * Show existing env values instead of y/n.
     */
    'show_values' => false,
];
