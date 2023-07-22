<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Helper;

use Exception;

class FileHelper
{
    private const FILE_DIR = 'var/files';

    public static function rootDirectory(): string
    {
        return dirname(__FILE__, 6);
    }

    /**
     * @throws Exception
     */
    public static function getPath(string $fileName): string
    {
        return self::rootDirectory() . DIRECTORY_SEPARATOR  .self::FILE_DIR . DIRECTORY_SEPARATOR . $fileName;
    }

    public static function getExtension(string $fileName): string
    {
        return explode('.', $fileName)[1] ?? throw new Exception();
    }

    public static function generateModifiedFileName(string $filename, string $extension): string
    {
        return $filename . '_modified_' . time() . '.' . $extension;
    }
}
