<?php

declare(strict_types=1);

namespace App\Modules\Image\UI\API;

use App\Modules\Image\UI\API\Controller\BaseController;
use App\Modules\Image\UI\API\Controller\Dto\ShowImageRequestDto;
use App\Modules\Image\UI\API\Controller\ShowImageController;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;

class RouteResolver
{
    private RouteCollection $routes;

    public function __construct(
        private readonly BaseController $baseController,
        private readonly ShowImageController $showImageController,
    ) {
    }

    public function __invoke(): string
    {
        $this->setRoutes();

        $matcher = new UrlMatcher($this->routes, new RequestContext('/'));
        $match = $matcher->match($_SERVER['REQUEST_URI']);

        if (!$match) {
            return $this->baseController->jsonError('Method not allowed');
        }

        switch ($match['_controller']) {
            case ShowImageController::class:
                $fileName = explode('?', $match['name'])[0];

                $dto = new ShowImageRequestDto($fileName);
                $dto->action = $_GET['action'] ?? null;
                $dto->height = isset($_GET['height']) ? (int) $_GET['height'] : null;
                $dto->width = isset($_GET['width']) ? (int) $_GET['width'] : null;

                return ($this->showImageController)($dto);
            default:
                return $this->baseController->jsonError('Not found');
        }
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
