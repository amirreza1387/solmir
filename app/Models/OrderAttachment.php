<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class OrderAttachment extends Model
{
    protected $fillable = [
        'order_id',
        'file_name',
        'file_path',
        'file_size',
        'mime_type',
    ];

    protected static function booted(): void
    {
        static::deleting(function (OrderAttachment $attachment) {
            if ($attachment->file_path) {
                if (Storage::disk('local')->exists($attachment->file_path)) {
                    Storage::disk('local')->delete($attachment->file_path);
                }
                if (Storage::disk('public')->exists($attachment->file_path)) {
                    Storage::disk('public')->delete($attachment->file_path);
                }
            }
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
