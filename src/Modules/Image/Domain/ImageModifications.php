<?php

declare(strict_types=1);

namespace App\Modules\Image\Domain;

enum ImageModifications
{
    case CROP;
    case RESIZE;

    public function value(): string
    {
        return match($this)
        {
            ImageModifications::CROP => 'crop',
            ImageModifications::RESIZE => 'resize',
        };
    }

    public static function key(string $action): ?ImageModifications
    {
        return match($action)
        {
            'crop' => ImageModifications::CROP,
            'resize' => ImageModifications::RESIZE,
        };
    }
}
