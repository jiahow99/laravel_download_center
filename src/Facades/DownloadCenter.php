<?php

namespace Mices\DownloadCenter\Facades;

use Illuminate\Support\Facades\Facade;

class DownloadCenter extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'download-center';
    }
}
