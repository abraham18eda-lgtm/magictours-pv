<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourTranslation extends Model
{
    protected $fillable = [
        'tour_id',
        'slug',
        'locale',
        'title',
        'description',
        'description_2',
        'recommendations',
        'requirements',
        'regular_price',
        'descount_price',
        'faq',
        'info'
    ];

    // Relación con Tour
    public function tour()
    {
        return $this->belongsTo(Tour::class);
    }

    // Relación Many-to-Many con amenities
    public function amenities()
    {
        return $this->belongsToMany(
            TourAmenity::class,
            'tour_translation_amenity', // tabla pivote
            'tour_translation_id',      // FK hacia TourTranslation
            'tour_amenity_id'           // FK hacia TourAmenity
        );
    }
}
