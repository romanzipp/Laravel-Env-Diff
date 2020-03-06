<?php

return [
    /*
     * Additional .env files which will be compared to the example
     * entries, like .env.test
     */
    'additional_files' => [
        '.env.example',
    ],

    /*
     * User colors when printing console output
     */
    'use_colors'       => true,

    /*
     * Hide variables that exist in all .env files
     */
    'hide_existing'    => true,

    /*
     * Show existing env values instead of y/n.
     */
    'show_values'      => false,
];
