<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'price_quad',
        'price_triple',
        'price_double',
        'departure_date',
        'duration_days',
        'hotel_makkah',
        'hotel_madinah',
        'airline_name',
        'featured_image',
        'description',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'price_quad' => 'decimal:2',
        'price_triple' => 'decimal:2',
        'price_double' => 'decimal:2',
        'departure_date' => 'date',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function itineraries(): HasMany
    {
        return $this->hasMany(Itinerary::class);
    }

    public function galleries(): HasMany
    {
        return $this->hasMany(PackageGallery::class);
    }

    public function inquiries(): HasMany
    {
        return $this->hasMany(PackageInquiry::class);
    }

    public function bookmarkedByUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'bookmarks')->withPivot('created_at');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
