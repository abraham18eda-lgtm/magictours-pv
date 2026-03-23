<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TourAmenity extends Model
{
    protected $fillable = [
        'name'
    ];

    // Relación inversa (opcional)
    public function translations()
    {
        return $this->belongsToMany(
            TourTranslation::class,
            'tour_translation_amenity',
            'tour_amenity_id',
            'tour_translation_id'
        );
    }
}
