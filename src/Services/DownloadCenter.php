<?php

namespace Mices\DownloadCenter\Services;

use Illuminate\Support\Facades\Auth;
use Mices\DownloadCenter\Jobs\ExportJob;
use Mices\DownloadCenter\Models\DownloadCenter as ModelsDownloadCenter;

class DownloadCenter
{
    public static function export($export, $filename, $initiated_by)
    {
        $userId = $userId ?? (Auth::check() ? Auth::id() : 0);

        // 1️⃣ Create download record
        $download = ModelsDownloadCenter::create([
            'name' => $filename,
            'initiated_by' => $initiated_by,
            'status' => ModelsDownloadCenter::STATUS_PENDING,
        ]);

        // 2️⃣ Dispatch job
        ExportJob::dispatch($export, $filename, $download->id);

        return $download;
    }
}
