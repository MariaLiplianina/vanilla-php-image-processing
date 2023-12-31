<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Validator;

use App\Modules\Image\Domain\ImageModifications;
use App\Modules\Image\UI\API\Controller\Dto\ShowImageRequestDto;

class ShowImageRequestDtoValidator
{
    /**
     * @throws \Exception
     */
    public function validate(ShowImageRequestDto $dto): void
    {
        if ($dto->action && !ImageModifications::key($dto->action)) {
            throw new \InvalidArgumentException('Unknown action');
        }

        if ($dto->action && !isset($dto->height) && !isset($dto->width)) {
            throw new \InvalidArgumentException('Height or width must be provided');
        }

        if ($dto->action && isset($dto->height) && $dto->height <= 0) {
            throw new \InvalidArgumentException('Invalid height');
        }

        if ($dto->action && isset($dto->width) && $dto->width <= 0) {
            throw new \InvalidArgumentException('Invalid width');
        }
    }
}
