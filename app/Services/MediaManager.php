<?php

namespace App\Services;

use Exception;
use Intervention\Image\Facades\Image;
use Plank\Mediable\Exceptions\MediaUpload\FileNotSupportedException;
use Plank\Mediable\MediaUploaderFacade as MediaUploader;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class MediaManager
{
    const THUMBNAIL_QUALITY = 100;

    /**
     * Upload media file.
     *
     * @param $file
     * @param string $type
     * @param string $destination
     *
     * @return \Plank\Mediable\Media
     * @throws Exception
     */
    public static function upload($file, string $type, string $destination = 'public')
    {
        $path = $type . '/' . date('Y') . '/' . date('m');

        try {
            $media = MediaUploader::fromSource($file)
                ->toDestination($destination, $path)
                ->useFilename(str_random(16))
                ->upload();

            $originalName = self::getOriginalName($file);

            $media->original_filename = $originalName;
            $media->save();

            return $media;
        } catch (Exception $e) {
            if ($e instanceof FileNotSupportedException) {
                $extension = array_get($e->getTrace(), '0.args.1');

                throw new Exception("File with `$extension` format is not allowed");
            }
        }
    }

    /**
     * Create a thumbnail and attach to original media file.
     *
     * @param        $media
     * @param string $type
     * @param string $mode
     * @param array  $size
     * @return mixed
     */
    public static function thumbnail($media, string $type, string $mode, array $size)
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'image') . '.' . $media->extension;

        $image = Image::make($media->getAbsolutePath());
        $image = call_user_func_array([$image, $mode], $size);
        $image->save($tmpFile, self::THUMBNAIL_QUALITY);

        $thumbnail = self::upload($tmpFile, $type);
        $thumbnail->attachMedia($media, 'original');

        return $thumbnail;
    }

    /**
     * Get the original name of file.
     *
     * @param $file
     * @return null|string
     */
    public static function getOriginalName($file)
    {
        $originalName = '';
        if ($file instanceof UploadedFile) {
            $originalName = $file->getClientOriginalName();
        } else if (is_string($file)) {
            $originalName = pathinfo($file)['basename'];
        }

        return $originalName;
    }
}
