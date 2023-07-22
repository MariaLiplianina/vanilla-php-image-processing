<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Processor;

use App\Modules\Image\Application\Helper\FileHelper;
use Exception;

class BaseImageProcessor
{
    protected const NAME = '';

    /**
     * @throws Exception
     */
    public static function getName(): string
    {
        return static::NAME ?: throw new Exception();
    }

    protected function validateFile(string $fileName): void
    {
        $path = FileHelper::getPath($fileName);
        if (!file_exists($path)) {
            throw new \Exception('File not found');
        }
    }

    protected function validateHeightAndWidth(?int $height = null, ?int $width = null): void
    {
        if (!$height && !$width) {
            throw new \Exception('Height or width must be provided');
        }

        if (isset($height) && $height <= 0) {
            throw new \InvalidArgumentException('Invalid height');
        }

        if (isset($width) && $width <= 0) {
            throw new \InvalidArgumentException('Invalid width');
        }
    }
}
