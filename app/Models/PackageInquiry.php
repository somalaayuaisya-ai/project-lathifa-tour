<?php

namespace App\Models;

use App\Enums\InquiryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageInquiry extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_id',
        'user_id',
        'guest_name',
        'guest_phone',
        'message',
        'status',
    ];

    protected $casts = [
        'status' => InquiryStatus::class,
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
