<?php

namespace App\Models\Image;

use Cloudinary\Configuration\Configuration;
use Cloudinary\Cloudinary;

class CloudinaryGateway
{

    public ?Cloudinary $cloudinary = null;

    public function __construct()
    {
        if (env('CLOUD_NAME') && env('API_KEY_CLOUD') && env('API_SECRET')) {
            $config = Configuration::instance();
            $config->cloud->cloudName = env('CLOUD_NAME');
            $config->cloud->apiKey = env('API_KEY_CLOUD');
            $config->cloud->apiSecret = env('API_SECRET');
            $config->url->secure = true;
            $this->cloudinary = new Cloudinary($config);
        }
    }

    public function destroyImage($publicId, $option): \Cloudinary\Api\ApiResponse
    {
        return $this->getUploadApi()->destroy($publicId, $option);
    }

    public function getUploadApi(): ?\Cloudinary\Api\Upload\UploadApi
    {
        return $this->getCloudinary()->uploadApi() ?? null;
    }

    private function getCloudinary(): Cloudinary
    {
        return $this->cloudinary;
    }

}
