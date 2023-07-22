<?php

declare(strict_types=1);

namespace App\Modules\Image\Application\Processor;

use App\Modules\Image\Application\Dto\FileData;
use App\Modules\Image\Application\Helper\FileHelper;
use DOMDocument;

class SvgProcessor extends BaseImageProcessor implements ImageProcessorInterface
{
    protected const NAME = 'svg';

    public function show(string $fileName): FileData
    {
        $path = FileHelper::getPath($fileName);
        if (!file_exists($path)) {
            throw new \Exception();
        }

        return new FileData($path, $fileName, file_get_contents($path));
    }

    public function crop(string $fileName, string $newFileName, ?int $height = null, ?int $width = null): void
    {
        //todo:
    }

    public function resize(string $fileName,  string $newFileName, ?int $height = null, ?int $width = null): void
    {
        if (!$height && !$width) {
            throw new \Exception('Height or width must be provided');
        }

        $dom = new DOMDocument('1.0', 'utf-8');
        $dom->load(FileHelper::getPath($fileName));
        $svg = $dom->documentElement;

        if (!$svg->hasAttribute('viewBox') ) {
            $pattern = '/^(\d*\.\d+|\d+)(px)?$/';

            $interpretable = preg_match($pattern, $svg->getAttribute('width'), $width) &&
                preg_match($pattern, $svg->getAttribute('height'), $height);

            if (!$interpretable) {
                throw new \Exception("viewBox is dependent on environment");
            }

            $viewBox = implode(' ', [0, 0, $width, $height]);
            $svg->setAttribute('viewBox', $viewBox);
        }

        $svg->setAttribute('width', (string) $width);
        $svg->setAttribute('height', (string) $height);

        $dom->save(FileHelper::getPath($newFileName));
    }
}
