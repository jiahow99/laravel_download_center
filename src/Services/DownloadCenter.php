<?php

namespace Mices\DownloadCenter\Services;

use App\Models\DownloadCenter as DownloadModel;
use App\Jobs\ExportJob;
use Illuminate\Support\Facades\Auth;

class DownloadCenter
{
    public static function export($export, $filename, $initiated_by)
    {
        $userId = $userId ?? (Auth::check() ? Auth::id() : 0);

        // 1️⃣ Create download record
        $download = DownloadModel::create([
            'name' => $filename,
            'initiated_by' => $initiated_by,
            'status' => DownloadModel::STATUS_PENDING,
        ]);

        // 2️⃣ Dispatch job
        ExportJob::dispatch($export, $filename, $download->id);

        return $download;
    }
}
