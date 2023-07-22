<?php

declare(strict_types=1);

namespace App\Modules\Image;

use App\Modules\Image\Application\Processor\ImageProcessorRegistry;
use App\Modules\Image\Application\Processor\RasterProcessor;
use App\Modules\Image\Application\Processor\SvgProcessor;
use App\Modules\Image\Application\Service\ImageService;
use App\Modules\Image\Application\Validator\ShowImageRequestDtoValidator;
use App\Modules\Image\UI\API\Controller\BaseController;
use App\Modules\Image\UI\API\Controller\Dto\ShowImageRequestDto;
use App\Modules\Image\UI\API\Controller\ShowImageController;
use Symfony\Component\Routing\Generator\UrlGenerator;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class Application
{
    private RouteCollection $routes;
    private RequestContext $requestContext;
    private UrlGenerator $urlGenerator;
    private BaseController $baseController;
    private ImageService $imageService;
    private ShowImageRequestDtoValidator $showImageRequestDtoValidator;

    public function __construct()
    {
        $this->setRoutes();

        $this->requestContext = new RequestContext('/');
        $this->urlGenerator = new UrlGenerator($this->routes, $this->requestContext);

        $registry = new ImageProcessorRegistry();
        $registry->registerProcessor(new RasterProcessor());
        $registry->registerProcessor(new SvgProcessor());

        $this->imageService = new ImageService($registry);
        $this->showImageRequestDtoValidator = new ShowImageRequestDtoValidator();
        $this->baseController = new BaseController();
    }

    public function __invoke(): string
    {
        $matcher = new UrlMatcher($this->routes, $this->requestContext);
        $match = $matcher->match($_SERVER['REQUEST_URI']);

        if (!$match) {
            return $this->baseController->jsonError('Method not allowed');
        }

        return match ($match['_controller']) {
            ShowImageController::class => $this->imageShow($match),
            default => $this->baseController->jsonError('Not found'),
        };
    }

    private function imageShow(array $match): string
    {
        $fileName = explode('?', $match['name'])[0];

        $dto = new ShowImageRequestDto($fileName);
        $dto->action = $_GET['action'] ?? null;
        $dto->height = isset($_GET['height']) ? (int) $_GET['height'] : null;
        $dto->width = isset($_GET['width']) ? (int) $_GET['width'] : null;

        return (new ShowImageController($this->imageService, $this->showImageRequestDtoValidator, $this->urlGenerator))($dto);
    }

    private function setRoutes(): void
    {
        $getCollection = new RouteCollection();
        $getCollection->setMethods(['GET']);
        $getCollection->add('image_show',
            new Route('/{name}', ['_controller' => ShowImageController::class])
        );

        $this->routes = new RouteCollection();
        $this->routes->addCollection($getCollection);
    }
}
