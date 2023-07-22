<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Service;

use App\Modules\Image\Application\Dto\FileData;
use App\Modules\Image\Application\Helper\FileHelper;
use App\Modules\Image\Application\Processor\ImageProcessorRegistry;
use Exception;

class ImageService
{
    public function __construct(private readonly ImageProcessorRegistry $registry)
    {
    }

    /**
     * @throws Exception
     */
    public function get(string $fileName): FileData
    {
        $processor = $this->registry->getProcessorByExtension(FileHelper::getExtension($fileName));

        return $processor->show($fileName);
    }

    /**
     * @throws Exception
     */
    public function crop(
        string $fileName,
        ?int $height = null,
        ?int $width = null
    ): FileData {
        if (!$height && !$width) {
            throw new \Exception('Height or width must be provided');
        }

        if (!file_exists(FileHelper::getPath($fileName))) {
            throw new Exception('File does not exist');
        }

        $fileNameParts = explode('.', $fileName);
        $extension = $fileNameParts[1] ?? throw new Exception('Invalid file name');

        $processor = $this->registry->getProcessorByExtension($extension);

        $newFileName = FileHelper::generateModifiedFileName($fileNameParts[0], $extension);
        $processor->crop($fileName, $newFileName, $height, $width);

        return $processor->show($newFileName);
    }

    public function resize(
        string $fileName,
        ?int $height = null,
        ?int $width = null,
    ): FileData {
        if (!$height && !$width) {
            throw new \Exception('Height or width must be provided');
        }

        if (!file_exists(FileHelper::getPath($fileName))) {
            throw new Exception();
        }

        $fileNameParts = explode('.', $fileName);
        $extension = $fileNameParts[1] ?? throw new Exception('Invalid file name');

        $processor = $this->registry->getProcessorByExtension($extension);

        $newFileName = FileHelper::generateModifiedFileName($fileNameParts[0], $extension);
        $processor->resize($fileName, $newFileName, $height, $width);

        return $processor->show($newFileName);
    }
}
