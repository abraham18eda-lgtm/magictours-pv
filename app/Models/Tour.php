<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tour extends Model
{
    protected $fillable = [
    'image',
    'site_id',
    'price',
    'short_description',
    'description',
    'tour_active'];

    public function translations()
    {
        return $this->hasMany(TourTranslation::class);
    }
    public function translation($locale)
    {
        return $this->translations->firstWhere('locale', $locale);
    }

    // public function translation($locale = null)
    // {
    //     $locale = $locale ?? app()->getLocale();
    //     return $this->translations->where('locale', $locale)->first();
    // }
}
