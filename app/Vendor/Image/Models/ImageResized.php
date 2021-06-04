<?php

namespace App\Vendor\Image\Models;

use Illuminate\Database\Eloquent\Model;

class ImageResized extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_image_resized';
    protected $guarded = [];

    public function configuration()
    {
        return $this->belongsTo(ImageConfiguration::class, 'image_configuration_id');
    }

    public function original_image()
    {
        return $this->belongsTo(ImageOriginal::class, 'image_original_id');
    }

    public function scopeGetImages($query, $entity, $entity_id){
        
        return $query->where('entity_id', $entity_id)
            ->where('entity', $entity);
    }
}
