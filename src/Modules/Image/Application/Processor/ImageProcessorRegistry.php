<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Processor;

class ImageProcessorRegistry
{
    /**
     * @var ImageProcessorInterface[]
     */
    protected array $registry = [];

    public function registerProcessor(ImageProcessorInterface $reader): void
    {
        $this->registry[$reader->getName()] = $reader;
    }

    /**
     * @throws \Exception
     */
    public function getProcessorByExtension(string $extension): ?ImageProcessorInterface
    {
        return match ($extension) {
            'jpg', 'jpeg', 'png', 'gif', 'tiff', 'webp' => $this->registry[RasterProcessor::getName()],
            'svg' => $this->registry[SvgProcessor::getName()],
            default  => throw new \Exception(),
        };
    }
}
