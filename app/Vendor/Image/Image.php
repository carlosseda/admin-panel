<?php

namespace App\Vendor\Image;

use Illuminate\Support\Facades\Storage;
use App\Vendor\Image\Models\ImageConfiguration;
use App\Vendor\Image\Models\Image as DBImage;
use App\Jobs\ProcessImage;
use App\Jobs\DeleteImage;
use Jcupitt\Vips;
use Debugbar;

class Image
{
	protected $entity;
	protected $extension_conversion;
	
	public function setEntity($entity)
	{
		$this->entity = $entity;
	}

	public function storeRequest($request, $extension_conversion, $foreign_id){

		$this->extension_conversion = $extension_conversion;
		
		foreach($request as $key => $file){

			$key = str_replace(['-', '_'], ".", $key); 
			$explode_key = explode('.', $key);
			$content = reset($explode_key);
			$language = end($explode_key);

			$image = $this->store($file, $foreign_id, $content, $language);
			$this->store_resize($file, $foreign_id, $content, $language, $image->path);
		}
	}

	public function store($file, $entity_id, $content, $language){

		$name = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
		$name = str_replace(" ", "-", $name);
		$file_extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));

		$filename = $name .'.'. $file_extension;

		if($file_extension != 'svg'){
			$data = getimagesize($file);
			$width = $data[0];
			$height = $data[1];
		}
		
		$settings = ImageConfiguration::where('entity', $this->entity)
		->where('content', $content)
		->where('grid', 'original')
		->first();

		$path = '/' . $entity_id . '/' . $language . '/' . $content . '/original/' . $name . '.' . $file_extension;
		$path = str_replace(" ", "-", $path);

		if($settings->type == 'single'){

			Storage::disk($this->entity)->deleteDirectory('/' . $entity_id . '/' . $language . '/' . $content . '/original');
			Storage::disk($this->entity)->putFileAs('/' . $entity_id . '/' . $language . '/' . $content . '/original', $file, $filename);

			$image = DBImage::updateOrCreate([
				'entity_id' => $entity_id,
				'entity' => $this->entity,
				'grid' => 'original',
				'language' => $language,
				'content' => $content],[
				'path' => $this->entity . $path,
				'filename' => $filename,
				'mime_type' => 'image/'. $file_extension,
				'size' => $file->getSize(),
				'width' => isset($width)? $width : null,
				'height' => isset($height)? $height : null,
				'quality' => 100,
				'image_configuration_id' => $settings->id,
			]);
		}

		elseif($settings->type == 'collection'){

			$counter = 2;
 
			while (Storage::disk($this->entity)->exists($path)) {
				
				$path = '/' . $entity_id . '/' . $language . '/' . $content . '/original/' . $name.'-'. $counter.'.'. $file_extension;
				$filename =  $name.'-'. $counter.'.'. $file_extension;
				$counter++;
			}

			Storage::disk($this->entity)->putFileAs('/' . $entity_id . '/' . $language . '/' . $content . '/original', $file, $filename);

			$image = DBImage::create([
				'entity_id' => $entity_id,
				'entity' => $this->entity,
				'grid' => 'original',
				'language' => $language,
				'content' => $content,
				'path' => $this->entity . $path,
				'filename' => $filename,
				'mime_type' => 'image/'. $file_extension,
				'size' => $file->getSize(),
				'width' => isset($width)? $width : null,
				'height' => isset($height)? $height : null,
				'quality' => 100,
				'image_configuration_id' => $settings->id,
			]);
		}

		return $image;
	}

	public function store_resize($file, $entity_id, $content, $language, $original_path){

		$name = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
		$file_extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
		$settings = ImageConfiguration::where('entity', $this->entity)
					->where('content', $content)
					->where('grid', '!=', 'original')
					->get();

		foreach ($settings as $setting => $value) {

			$content_accepted = explode("/", $value->content_accepted);

			if(!in_array($file_extension, $content_accepted)){
				continue;
			}
			
			if($file_extension == 'svg'){
				$directory = '/' . $entity_id . '/' . $language . $value->directory; 
				$path = $directory . '/' . $name . '.' . $file_extension;
				$path = str_replace(" ", "-", $path);
				$filename = $name . '.' . $file_extension;
			}else{
				$directory = '/' . $entity_id . '/' . $language . $value->directory; 
				$path = $directory . '/' . $name . '.' . $this->extension_conversion;
				$path = str_replace(" ", "-", $path);
				$filename = $name . '.' . $this->extension_conversion;
			}		

			if($value->type == 'single'){

				ProcessImage::dispatch(
					$entity_id,
					$value->entity,
					$directory,
					$value->grid,
					$language, 
					$value->disk,
					$path, 
					$filename, 
					$value->content,
					$value->type,
					$file_extension,
					$this->extension_conversion,
					$value->width,
					$value->quality,
					$original_path, 
					$value->id
				)->onQueue('process_image');
			}

			elseif($value->type == 'collection'){

				$counter = 2;

				while (Storage::disk($value->disk)->exists($path)) {
					
					if($file_extension == 'svg'){
						$path =  '/' . $entity_id . '/' . $language . $value->directory . '/' . $name.'-'. $counter.'.'. $file_extension;
						$filename = $name .'-'. $counter.'.'. $file_extension;
						$counter++;
					}else{
						$path =  '/' . $entity_id . '/' . $language . $value->directory . '/' . $name.'-'. $counter.'.'. $this->extension_conversion;
						$filename = $name .'-'. $counter.'.'. $this->extension_conversion;
						$counter++;
					}		
				}

				ProcessImage::dispatch(
					$entity_id,
					$value->entity,
					$directory,
					$value->grid,
					$language, 
					$value->disk,
					$path, 
					$filename, 
					$value->content,
					$value->type,
					$extension,
					$this->extension_conversion,
					$value->width,
					$value->quality,
					$original_path, 
					$value->id
				)->onQueue('process_image');
			}
		}
	}

	public function show($entity_id, $language)
	{
		return DBImage::getPreviewImage($this->entity, $entity_id, $language)->first();
	}

	public function preview($entity_id)
	{
		$items = DBImage::getPreviewImage($this->entity, $entity_id)->pluck('path','language')->all();

        return $items;
	}

	public function galleryImage($entity, $grid, $entity_id, $filename)
	{
		
		$image = DBImage::getGalleryImage($entity, $entity_id, $filename, $grid)->first();

		return response()->json([
			'path' => Storage::url($image->path),
		]); 
	}

	public function galleryPreviousImage($entity, $grid, $entity_id, $id)
	{		

		$image = DBImage::getGalleryPreviousImage($entity_id, $entity, $grid, $id)->first();

		$previous = route('gallery_previous_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);
		$next = route('gallery_next_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);

		return response()->json([
			'path' => Storage::url($image->path),
			'previous' => $previous,
			'next' => $next
		]); 
	}

	public function galleryNextImage($entity, $grid, $entity_id, $id)
	{

		$image = DBImage::getGalleryNextImage($entity_id, $entity, $grid, $id)->first();

		$previous = route('gallery_previous_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);
		$next = route('gallery_next_image', ['entity' => $entity, 'grid' => $grid, 'entity_id' => $entity_id, 'id' => $image->id]);

		return response()->json([
			'path' => Storage::url($image->path),
			'previous' => $previous,
			'next' => $next
		]); 
	}

	public function original($entity_id)
	{
		$items = DBImage::getOriginalImage($this->entity, $entity_id)->pluck('path','language')->all();

        return $items;
	}

	public function getAllByLanguage($language){ 

        $items = DBImage::getAllByLanguage($this->entity, $language)->get()->groupBy('entity_id');

        $items =  $items->map(function ($item) {
            return $item->pluck('path','grid');
        });

        return $items;
    }

	public function destroy(DBImage $image)
	{
		DeleteImage::dispatch($image->filename, $image->content, $image->entity)->onQueue('delete_image');

		$message = \Lang::get('admin/media.media-delete');

		return response()->json([
            'message' => $message,
        ]);
	}

	public function delete($entity_id)
	{
		if (DBImage::getImages($this->entity, $entity_id)->count() > 0) {

			$images = DBImage::getImages($this->entity, $entity_id)->get();

			foreach ($images as $image){
				Storage::disk($image->entity)->delete($image->path);
				$image->delete();
			}
		}
	}
}
