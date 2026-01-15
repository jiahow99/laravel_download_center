<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DownloadCenter extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'initiated_by',
        'status',
        'path',
        'exception',
    ];

    public const STATUS_PENDING = 0;
    public const STATUS_COMPLETED = 1;
    public const STATUS_FAILED = 2;
    public const STATUS_EXPIRED = 3;

    public function initiatedBy()
    {
        return $this->belongsTo(User::class, 'initiated_by');
    }

    public static function getStatusLabel($id)
    {
        return match ($id) {
            self::STATUS_PENDING => 'Pending',
            self::STATUS_COMPLETED => 'Completed',
            self::STATUS_FAILED => 'Failed',
            self::STATUS_EXPIRED => 'Expired',
            default => null,
        };
    }
}
