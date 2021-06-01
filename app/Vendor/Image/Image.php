<?php

namespace App\Vendor\Image;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Vendor\Image\Models\ImageConfiguration;
use App\Vendor\Image\Models\ImageOriginal;
use App\Vendor\Image\Models\ImageResized;
use App\Jobs\ProcessImage;
use App\Jobs\DeleteImage;
use App\Jobs\DeleteTemporalImage;
use Jcupitt\Vips;

class Image
{
	protected $entity;
	protected $extension_conversion;
	
	public function setEntity($entity)
	{
		$this->entity = $entity;
	}

	public function store($request, $entity_id){
		
		foreach($request as $key => $file){

			$key = str_replace(['-', '_'], ".", $key); 
			$explode_key = explode('.', $key);
			$content = reset($explode_key);
			$language = end($explode_key);

			$temporal_id = str_replace(['.', $content, $language], "", $key);

			$image = $this->storeOriginal($file, $entity_id, $content, $language);
			$image->temporal_id = $temporal_id;

			$this->storeResize($file, $entity_id, $content, $language, $image);
		}

		$this->destroyTemporal();
	}

	public function storeSeo(Request $request){

		$settings = ImageConfiguration::where('entity', request('entity'))
				->where('content', request('content'))
				->where('grid', '!=', 'original')
				->get();

		if(request('temporalId')){

			foreach ($settings as $setting => $configuration){

				ImageResized::updateOrCreate([
					'temporal_id' => request('temporalId'),
					'grid' => $configuration->grid],[
					'title' => request('title'),
					'entity' => request('entity'),
					'language' => request('language'),
					'content' => request('content'),
					'alt' => request('alt'),
				]);
			}
		}
			
		if(request('imageId')){

			$entity_id = ImageResized::find(request('imageId'))->entity_id;

			foreach ($settings as $setting => $configuration){

				$image = ImageResized::updateOrCreate([
					'entity_id' => $entity_id,
					'grid' => $configuration->grid,
					'filename' => request('filename'),
					'entity' => request('entity'),
					'language' => request('language'),
					'content' => request('content')],[
					'title' => request('title'),
					'alt' => request('alt'),
				]);
			}
		}
	
		$message = \Lang::get('admin/image.image-update');

		return response()->json([
            'message' => $message,
        ]); 
	}

	public function storeOriginal($file, $entity_id, $content, $language){

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

			$image = ImageOriginal::updateOrCreate([
				'entity_id' => $entity_id,
				'entity' => $this->entity,
				'language' => $language,
				'content' => $content],[
				'path' => $this->entity . $path,
				'filename' => $filename,
				'mime_type' => 'image/'. $file_extension,
				'size' => $file->getSize(),
				'width' => isset($width)? $width : null,
				'height' => isset($height)? $height : null,
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

			$image = ImageOriginal::create([
				'entity_id' => $entity_id,
				'entity' => $this->entity,
				'language' => $language,
				'content' => $content,
				'path' => $this->entity . $path,
				'filename' => $filename,
				'mime_type' => 'image/'. $file_extension,
				'size' => $file->getSize(),
				'width' => isset($width)? $width : null,
				'height' => isset($height)? $height : null,
			]);

		}

		return $image;
	}

	public function storeResize($file, $entity_id, $content, $language, $image){

		$name = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME));
		$file_extension = strtolower(pathinfo($file->getClientOriginalName(), PATHINFO_EXTENSION));
		$settings = ImageConfiguration::where('entity', $this->entity)
					->where('content', $content)
					->where('grid', '!=', 'original')
					->get();

		foreach ($settings as $setting => $configuration) {

			$content_accepted = explode("/", $configuration->content_accepted);

			if(!in_array($file_extension, $content_accepted)){
				continue;
			}
			
			if($file_extension == 'svg'){
				$directory = '/' . $entity_id . '/' . $language . $configuration->directory; 
				$path = $directory . '/' . $name . '.' . $file_extension;
				$path = str_replace(" ", "-", $path);
				$filename = $name . '.' . $file_extension;
			}else{
				$directory = '/' . $entity_id . '/' . $language . $configuration->directory; 
				$path = $directory . '/' . $name . '.' . $configuration->extension_conversion;
				$path = str_replace(" ", "-", $path);
				$filename = $name . '.' . $configuration->extension_conversion;
			}		

			if($configuration->type == 'collection'){

				$counter = 2;

				while (Storage::disk($configuration->disk)->exists($path)) {
					
					if($file_extension == 'svg'){
						$path =  '/' . $entity_id . '/' . $language . $configuration->directory . '/' . $name.'-'. $counter.'.'. $file_extension;
						$filename = $name .'-'. $counter.'.'. $file_extension;
						$counter++;
					}else{
						$path =  '/' . $entity_id . '/' . $language . $configuration->directory . '/' . $name.'-'. $counter.'.'. $this->extension_conversion;
						$filename = $name .'-'. $counter.'.'. $configuration->extension_conversion;
						$counter++;
					}		
				}
			}

			ProcessImage::dispatch(
				$entity_id,
				$configuration->entity,
				$directory,
				$configuration->grid,
				$language, 
				$configuration->disk,
				$path, 
				$filename, 
				$configuration->content,
				$configuration->type,
				$file_extension,
				$configuration->extension_conversion,
				$configuration->width,
				$configuration->quality,
				$image->path, 
				$configuration->id,
				$image->id,
				$image->temporal_id
			)->onQueue('process_image');
		}
	}

	public function show(Request $request, $image)
	{		
		return ImageResized::with('original_image')->find($image);
	}

	public function showTemporal(Request $request, $image = null)
	{		
		return ImageResized::where('temporal_id', $request->input('image'))->first();
	}

	public function destroy(Request $request, $image = null)
	{
		$image = ImageResized::find($request->input('image'));

		DeleteImage::dispatch($image->filename, $image->content, $image->entity, $image->language)->onQueue('delete_image');

		$message = \Lang::get('admin/image.image-delete');

		return response()->json([
			'imageId' => $request->input('image'),
            'message' => $message,
        ]);
	}

	public function destroyTemporal()
	{
		deleteTemporalImage::dispatch()->onQueue('process_image');
	}
}
