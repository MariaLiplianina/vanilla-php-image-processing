<?php

declare(strict_types=1);

namespace App\Modules\Image\UI\API\Controller;

use App\Modules\Image\Application\Service\ImageService;
use App\Modules\Image\Application\Validator\ShowImageRequestDtoValidator;
use App\Modules\Image\Domain\ImageModifications;
use App\Modules\Image\UI\API\Controller\Dto\ShowImageRequestDto;

class ShowImageController extends BaseController
{
    public function __construct(
        private readonly ImageService $imageService,
        private readonly ShowImageRequestDtoValidator $validator,
    ) {
    }

    public function __invoke(ShowImageRequestDto $dto): string
    {
        try {
            $fileName = $dto->fileName;

            if ($dto->action) {
                $this->validator->validate($dto);

                if ($dto->action === ImageModifications::CROP->value()) {
                    $fileData = $this->imageService->crop($fileName, $dto->height, $dto->width);
                }

                if ($dto->action === ImageModifications::RESIZE->value()) {
                    $fileData = $this->imageService->resize($fileName, $dto->height, $dto->width);
                }

                return $fileData->content;
            }

            $fileData = $this->imageService->get($fileName);

            return $fileData->content;
        } catch (\Throwable $t) {
            return $this->jsonError($t->getMessage());
        }
    }
}
