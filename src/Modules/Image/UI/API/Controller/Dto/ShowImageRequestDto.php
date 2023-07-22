<?php

declare(strict_types=1);

namespace App\Modules\Image\UI\API\Controller\Dto;

class ShowImageRequestDto
{
    public string $fileName;
    public ?string $action = null;
    public ?int $height = null;
    public ?int $width = null;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }
}
