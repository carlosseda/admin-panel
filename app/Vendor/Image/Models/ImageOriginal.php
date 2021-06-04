<?php

namespace App\Vendor\Image\Models;

use Illuminate\Database\Eloquent\Model;

class ImageOriginal extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 't_image_original';
    protected $guarded = [];

    public function scopeGetImages($query, $entity, $entity_id){
        
        return $query->where('entity_id', $entity_id)
            ->where('entity', $entity);
    }
}
