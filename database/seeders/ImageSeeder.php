<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Vendor\Image\Models\ImageConfiguration;

class ImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $image_configurations = array(
            array(
                'entity' => 'faqs',
                'disk' => 'faqs',
                'directory' => '/featured/original',
                'type' => 'single',
                'content' => 'featured',
                'grid' => 'original',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => null,
                'height' => null,
                'quality' => 100
            ),
            array(
                'entity' => 'faqs',
                'disk' => 'faqs',
                'directory' => '/featured/preview',
                'type' => 'single',
                'content' => 'featured',
                'grid' => 'preview',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '200',
                'height' => '200',
                'quality' => 100
            ),
            array(
                'entity' => 'faqs',
                'disk' => 'faqs',
                'directory' => '/featured/desktop',
                'type' => 'single',
                'content' => 'featured',
                'grid' => 'desktop',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '200',
                'height' => '200',
                'quality' => 100
            ),
            array(
                'entity' => 'faqs',
                'disk' => 'faqs',
                'directory' => '/featured/mobile',
                'type' => 'single',
                'content' => 'featured',
                'grid' => 'mobile',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '200',
                'height' => '200',
                'quality' => 100
            ),
            array(
                'entity' => 'business_information',
                'disk' => 'business_information',
                'directory' => '/logo/original',
                'type' => 'single',
                'content' => 'logo',
                'grid' => 'original',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => null,
                'height' => null,
                'quality' => 100
            ),
            array(
                'entity' => 'business_information',
                'disk' => 'business_information',
                'directory' => '/logo/preview',
                'type' => 'single',
                'content' => 'logo',
                'grid' => 'preview',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '180',
                'height' => '60',
                'quality' => 100
            ),
            array(
                'entity' => 'business_information',
                'disk' => 'business_information',
                'directory' => '/logo/desktop',
                'type' => 'single',
                'content' => 'logo',
                'grid' => 'desktop',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '180',
                'height' => '60',
                'quality' => 100
            ),
            array(
                'entity' => 'business_information',
                'disk' => 'business_information',
                'directory' => '/logo/mobile',
                'type' => 'single',
                'content' => 'logo',
                'grid' => 'mobile',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '180',
                'height' => '60',
                'quality' => 100
            ),
            array(
                'entity' => 'business_information',
                'disk' => 'business_information',
                'directory' => '/logolight/original',
                'type' => 'single',
                'content' => 'logolight',
                'grid' => 'original',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => null,
                'height' => null,
                'quality' => 100
            ),
            array(
                'entity' => 'business_information',
                'disk' => 'business_information',
                'directory' => '/logolight/preview',
                'type' => 'single',
                'content' => 'logolight',
                'grid' => 'preview',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '180',
                'height' => '60',
                'quality' => 100
            ),
            array(
                'entity' => 'business_information',
                'disk' => 'business_information',
                'directory' => '/logolight/desktop',
                'type' => 'single',
                'content' => 'logolight',
                'grid' => 'desktop',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '180',
                'height' => '60',
                'quality' => 100
            ),
            array(
                'entity' => 'business_information',
                'disk' => 'business_information',
                'directory' => '/logolight/mobile',
                'type' => 'single',
                'content' => 'logolight',
                'grid' => 'mobile',
                'content_accepted' => 'jpg/jpeg/png/svg/webp',
                'extension_conversion' => 'webp',
                'width' => '180',
                'height' => '60',
                'quality' => 100
            ),
        );

        foreach ($image_configurations  as $image_configuration){

            ImageConfiguration::create([
                'entity' => $image_configuration['entity'],
                'disk' => $image_configuration['disk'],
                'directory' => $image_configuration['directory'],
                'type' => $image_configuration['type'],
                'content' => $image_configuration['content'],
                'grid' => $image_configuration['grid'],
                'content_accepted' => $image_configuration['content_accepted'],
                'extension_conversion' => $image_configuration['extension_conversion'],
                'width' => $image_configuration['width'],
                'height' => $image_configuration['height'],
                'quality' => $image_configuration['quality'],
            ]);
        }

    }
}
