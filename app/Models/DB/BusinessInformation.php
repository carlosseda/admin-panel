<?php

namespace App\Models\DB;

use App\Vendor\Image\Models\ImageResized;

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
}
