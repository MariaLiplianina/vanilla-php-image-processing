<?php

use App\Modules\Image\Application\Processor\ImageProcessorRegistry;
use App\Modules\Image\Application\Processor\RasterProcessor;
use App\Modules\Image\Application\Processor\SvgProcessor;
use App\Modules\Image\Application\Service\ImageService;
use App\Modules\Image\Application\Validator\ShowImageRequestDtoValidator;
use App\Modules\Image\UI\API\Controller\BaseController;
use App\Modules\Image\UI\API\Controller\ShowImageController;
use App\Modules\Image\UI\API\RouteResolver;

require_once dirname(__DIR__) . '/vendor/autoload.php';

$baseController = new BaseController();

$registry = new ImageProcessorRegistry();
$registry->registerProcessor(new RasterProcessor());
$registry->registerProcessor(new SvgProcessor());

$showImageController = new ShowImageController(new ImageService($registry), new ShowImageRequestDtoValidator());

echo (new RouteResolver($baseController, $showImageController))();
