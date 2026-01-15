<?php

return [
    // Filesystem disk for storing downloads
    'disk' => 'download',

    // Auto-register the disk
    'disks' => [
        'download' => [
            'driver' => 'local',
            'root' => storage_path('app/public/downloads'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],
    ],

];
