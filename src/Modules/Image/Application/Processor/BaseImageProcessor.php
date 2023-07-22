<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Processor;

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
}
