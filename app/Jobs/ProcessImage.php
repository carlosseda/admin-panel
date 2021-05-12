<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Storage;
use Jcupitt\Vips;
use App\Vendor\Image\Models\ImageResize;
use App\Vendor\Image\Models\ImageConfiguration;
use Debugbar;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $entity_id;
    protected $entity;
    protected $directory;
    protected $grid;
    protected $language;
    protected $disk;
    protected $path;
    protected $filename;
    protected $content;
    protected $type;
    protected $file_extension;
    protected $extension_conversion;
    protected $width;
    protected $quality;
    protected $file;
    protected $format_conversion;
    protected $image_configuration_id;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $entity_id, 
        $entity,
        $directory,
        $grid,
        $language, 
        $disk,
        $path, 
        $filename, 
        $content,
        $type,
        $file_extension,
        $extension_conversion,
        $width,
        $quality,
        $file, 
        $image_configuration_id
    ){
        $this->entity_id = $entity_id;
        $this->entity = $entity;
        $this->directory = $directory;
        $this->grid = $grid;
        $this->language = $language;
        $this->disk = $disk;
        $this->path = $path;
        $this->filename = $filename;
        $this->content = $content;
        $this->type = $type;
        $this->file_extension = $file_extension;
        $this->extension_conversion = $extension_conversion;
        $this->width = $width;
        $this->quality = $quality;
        $this->file = $file;
        $this->image_configuration_id = $image_configuration_id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Vips\Config::concurrencySet(1);
        Vips\Config::CacheSetMax(0);
        $this->file = Storage::disk('public')->get($this->file);

        if($this->type == 'single'){
            Storage::disk($this->disk)->deleteDirectory($this->directory);
        }

        if($this->file_extension != 'svg'){
            $buffer = Vips\Image::thumbnail_buffer($this->file, $this->width)->webpsave_buffer(["Q" => $this->quality]);
            Storage::disk($this->disk)->put($this->path, (string) $buffer);

            $path = public_path(Storage::url($this->disk . $this->path));
            $size = filesize($path);
            $data = getimagesize($path);
            $height = $data[1];

        }else{
            Storage::disk($this->disk)->put($this->path, (string) $this->file);

            $path = public_path(Storage::url($this->disk . $this->path));
            $size = filesize($path);
        }
        
        
        if($this->type == 'single'){

            ImageResize::updateOrCreate([
                'entity_id' => $this->entity_id,
                'entity' => $this->entity,
                'grid' => $this->grid,
                'language' => $this->language,
                'content' => $this->content],[
                'path' => $this->disk . $this->path,
                'filename' => $this->filename,
                'mime_type' => $this->file_extension == "svg" ? 'image/'. $this->file_extension : 'image/'. $this->extension_conversion,
                'size' => $size,
                'width' => $this->width,
				'height' => isset($height)? $height : null,
                'quality' => $this->quality,
                'image_configuration_id' => $this->image_configuration_id,
            ]);
        }

        elseif($this->type == 'collection'){

            ImageResize::create([
                'entity_id' => $this->entity_id,
                'entity' => $this->entity,
                'grid' => $this->grid,
                'language' => $this->language,
                'content' => $this->content,
                'path' => $this->disk . $this->path,
                'filename' => $this->filename,
                'mime_type' => $this->file_extension == "svg" ? 'image/'. $this->file_extension : 'image/'. $this->extension_conversion,
                'size' => $size,
                'width' => $this->width,
                'height' => $height,
                'quality' => $this->quality,
                'image_configuration_id' => $this->image_configuration_id,
            ]);
        }
    }
}
