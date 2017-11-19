<?php

return [

    /*
     * List of folders to be analyzed.
     */
    'paths' => [
        base_path('app'),
        base_path('database'),
        base_path('tests'),
    ],

    /*
     * List of files/folders to be excluded from analysis.
     */
    'exclude' => [
        // base_path('app/helpers.php'),
        // base_path('app/Services'),
    ],

    /*
     * The Filter Strategy used when searching for Classes
     * in your list of paths.
     * For most project the default is fine, but if you want
     * to customize which files should count to your statistics,
     * you can customize this here.
     *
     * The package ships with 2 filters:
     * - \Wnx\LaravelStats\Filters\RejectVendorClasses
     * - \Wnx\LaravelStats\Filters\RejectInternalClasses
     */
    'filter' => \Wnx\LaravelStats\Filters\RejectVendorClasses::class,

];
