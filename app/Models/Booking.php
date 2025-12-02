<?php

namespace App\Models;

use App\Enums\BookingStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'package_id',
        'package_inquiry_id',
        'total_amount',
        'status',
        'payment_proof_url',
        'notes',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'status' => BookingStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function inquiry(): BelongsTo
    {
        return $this->belongsTo(PackageInquiry::class, 'package_inquiry_id');
    }
}
