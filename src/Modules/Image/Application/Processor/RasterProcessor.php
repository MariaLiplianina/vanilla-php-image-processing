<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Processor;

use App\Modules\Image\Application\Dto\FileData;
use App\Modules\Image\Application\Helper\FileHelper;
use Imagick;

class RasterProcessor extends BaseImageProcessor implements ImageProcessorInterface
{
    protected const NAME = 'raster';

    public function show(string $fileName): FileData
    {
        $path = FileHelper::getPath($fileName);
        if (!file_exists($path)) {
            throw new \Exception('File not found');
        }

        return new FileData(
            $path,
            $fileName,
            '<img src="data:image/'
            . FileHelper::getExtension($fileName)
            . ';base64,'
            . base64_encode(file_get_contents($path)) . '">'
        );
    }

    /**
     * @throws \ImagickException
     * @throws \Exception
     */
    public function crop(string $fileName, string $newFileName, ?int $height = null, ?int $width = null): void
    {
        $this->validateHeightAndWidth($height, $width);
        $this->validateFile($fileName);

        $path = FileHelper::getPath($fileName);
        $image = new \Imagick($path);

        $height = $height ?? $image->getImageHeight();
        $width = $width ?? $image->getImageWidth();

        $image->cropImage($width, $height, 0, 0);

        $image->writeImage(FileHelper::getPath($newFileName));
    }

    /**
     * @throws \ImagickException
     * @throws \Exception
     */
    public function resize(string $fileName, string $newFileName, ?int $height = null, ?int $width = null): void
    {
        $this->validateHeightAndWidth($height, $width);
        $this->validateFile($fileName);

        $path = FileHelper::getPath($fileName);
        $image = new \Imagick($path);

        $height = $height ?? $image->getImageHeight();
        $width = $width ?? $image->getImageWidth();

        $image->resizeImage($width, $height, Imagick::FILTER_CATROM, 0);

        $image->writeImage(FileHelper::getPath($newFileName));
    }
}
