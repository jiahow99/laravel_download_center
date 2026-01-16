<?php

namespace Mices\DownloadCenter;

use Illuminate\Support\ServiceProvider;
use Mices\DownloadCenter\Services\DownloadCenter;

class DownloadCenterServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton('download-center', function () {
            return new DownloadCenter();
        });
    }

    public function boot()
    {
        // Merge your config
        $this->mergeConfigFrom(__DIR__.'/../config/download_center.php', 'download_center');

        // Auto-add disk to config('filesystems.disks') if not exists
        $disks = config('filesystems.disks');

        $downloadDisk = config('download_center.disks.download');

        if (!isset($disks['download'])) {
            $disks['download'] = $downloadDisk;
            config(['filesystems.disks' => $disks]);
        }

        // Load migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // Publish 
        $this->publishes([
             __DIR__.'/../config/download_center.php' => config_path('download_center.php'),
            __DIR__.'/./Models/DownloadCenter.php' => app_path('Models/DownloadCenter.php'),
            __DIR__.'/../stubs/DownloadCenterCrudController.php' => app_path('Http/Controllers/Admin/DownloadCenterCrudController.php'),
            __DIR__.'/../stubs/download.blade.php' => resource_path('views/vendor/backpack/crud/buttons/download.blade.php'),
            __DIR__.'/../database/migrations/2026_01_15_095205_create_download_centers_table.php' => database_path('migrations/2026_01_15_095205_create_download_centers_table.php'),
        ], 'download-center');
    }
}
