<?php

return [

    /*
     * Ever project is different and sometimes files
     * and folders should be ignored and never
     * count towards the project stats.
     */
    'ignore' => [

        /*
         * Ignore the contents of an entire folder
         */
        'folders' => [
            // 'app/Http/Controllers'
        ],

        /*
         * Ignore certain file names or extensions
         */
        'files' => [
            // 'helpers.php'
            // 'twig.php'
        ],

    ],

];
