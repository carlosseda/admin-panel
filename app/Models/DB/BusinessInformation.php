<?php

namespace App\Models\DB;

use App\Vendor\Image\Models\ImageResized;
use App;

class BusinessInformation extends DBModel
{

    protected $table = 't_business_information';

    public function images_logo_preview()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'preview')->where('content', 'logo')->where('entity', 'business_information');
    }

    public function images_logolight_preview()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'preview')->where('content', 'logolight')->where('entity', 'business_information');
    }

    public function images_our_business_preview()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'preview')->where('content', 'ourbusiness')->where('entity', 'business_information');
    }

    public function image_our_business_desktop()
    {
        return $this->hasOne(ImageResized::class, 'entity_id')->where('grid', 'desktop')->where('content', 'ourbusiness')->where('entity', 'business_information')->where('language', App::getLocale());
    }

    public function image_our_business_mobile()
    {
        return $this->hasOne(ImageResized::class, 'entity_id')->where('grid', 'mobile')->where('content', 'ourbusiness')->where('entity', 'business_information')->where('language', App::getLocale());
    }

    public function images_our_fleet_preview()
    {
        return $this->hasMany(ImageResized::class, 'entity_id')->where('grid', 'preview')->where('content', 'ourfleet')->where('entity', 'business_information');
    }

    public function image_our_fleet_desktop()
    {
        return $this->hasOne(ImageResized::class, 'entity_id')->where('grid', 'desktop')->where('content', 'ourfleet')->where('entity', 'business_information')->where('language', App::getLocale());
    }

    public function image_our_fleet_mobile()
    {
        return $this->hasOne(ImageResized::class, 'entity_id')->where('grid', 'mobile')->where('content', 'ourfleet')->where('entity', 'business_information')->where('language', App::getLocale());
    }
}
