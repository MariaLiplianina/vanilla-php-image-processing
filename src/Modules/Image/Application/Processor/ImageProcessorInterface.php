<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Processor;

use App\Modules\Image\Application\Dto\FileData;

interface ImageProcessorInterface
{
    public function show(string $fileName): FileData;
    public function crop(string $fileName, string $newFileName, ?int $height = null, ?int $width = null): void;
    public function resize(string $fileName,  string $newFileName, ?int $height = null, ?int $width = null): void;
}
