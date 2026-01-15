<?php

namespace Mices\DownloadCenter\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;
use Mices\DownloadCenter\Models\DownloadCenter;
use Throwable;

class ExportJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $export;
    protected $filename;
    protected $download_id;

    /**
     * Create a new job instance.
     */
    public function __construct($export, $filename, $download_id)
    {
        $this->onQueue('download');
        $this->export = $export;
        $this->filename = $filename;
        $this->download_id = $download_id;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Excel::store($this->export, $this->filename, 'download');
    
            DownloadCenter::find($this->download_id)->update([
                'status' => DownloadCenter::STATUS_COMPLETED,
                'path' => 'download/' . $this->filename,
            ]);
        } catch (\Throwable $th) {
            $this->failed($th);
        }
    }

    public function failed(Throwable $e): void
    {
        if ($download = DownloadCenter::find($this->download_id)) {
            $download->update([
                'status' => DownloadCenter::STATUS_FAILED,
                'exception' => $e->getMessage(),
            ]);
        }
    }
}
