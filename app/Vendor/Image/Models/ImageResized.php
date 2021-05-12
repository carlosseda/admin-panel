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

    public function scopeGetImages($query, $entity, $entity_id){
        
        return $query->where('entity_id', $entity_id)
            ->where('entity', $entity);
    }

    public function scopeGetImage($query, $entity, $grid, $entity_id, $language){
        
        return $query->where('entity_id', $entity_id)
            ->where('entity', $entity)
            ->where('entity_id', $entity_id )
            ->where('language', $language)
            ->where('grid', $grid);
    }

    public function scopeGetAllByLanguage($query, $entity, $language){
        
        return $query->where('language', $language)
            ->where('entity', $entity);
    }

    public function scopeGetGalleryImage($query, $entity, $entity_id, $filename, $grid){
        
        return $query->where('entity_id', $entity_id)
            ->where('entity', $entity)
            ->where('filename', $filename)
            ->where('grid', $grid);
    }

    public function scopeGetGalleryPreviousImage($query, $entity_id, $entity, $grid,  $id){
        
        return $query->where('entity_id', $entity_id)
            ->where('entity', $entity)
            ->where('grid', $grid)
            ->where('id', '<', $id)
            ->orderBy('id','desc');
    }

    public function scopeGetGalleryNextImage($query, $entity_id, $entity, $grid,  $id){
        
        return $query->where('entity_id', $entity_id)
            ->where('entity', $entity)
            ->where('grid', $grid)
            ->where('id', '>', $id)
            ->orderBy('id','asc');
    }

    public function scopeGetOriginalImage($query, $entity, $entity_id){
        
        return $query->where('entity_id', $entity_id)
            ->where('entity', $entity)
            ->where('grid', 'original')
            ->select('path','filename','language');
    }
}
