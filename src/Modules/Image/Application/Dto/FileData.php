<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Dto;

class FileData
{
    public function __construct(
        public readonly string $path,
        public readonly string $fileName,
        public readonly ?string $content = null,
    ) {
    }
}
