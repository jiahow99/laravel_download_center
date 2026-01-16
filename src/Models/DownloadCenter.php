<?php

namespace Mices\DownloadCenter\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\app\Models\Traits\CrudTrait;

class DownloadCenter extends Model
{
    use HasFactory;
    use CrudTrait;

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
