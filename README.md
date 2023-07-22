### Architecture

This repository implements Clean architecture (Domain, Application, Infrastructure and UI Layers) and Domain Driven Design (Entities, Repositories, Application Services...) with applying SOLID principles.

### System requirements
- Docker Engine installed (see [Docker Engine overview](https://docs.docker.com/install/))
- Docker Compose installed (see [Install Docker Compose](https://docs.docker.com/compose/install/))

### Installation

The project is dockerized and configured to work with docker compose
- `docker compose up -d`
- `docker compose exec -T -u www-data -e XDEBUG_MODE=off php-fpm composer install` 

#### Other commands:

Run tests
- `docker compose exec -T -u www-data -e XDEBUG_MODE=off php-fpm ./vendor/bin/phpunit`

### Business rules

A small image service which can deliver images using a GET request and which are stored on the server. It is possible to use different modifiers to change what will be returned. 
Two modifiers are implemented:

- crop-modifier (will cut the image and will take height and width as parameters)
- resize-modifier (resizes the images based on given height and width as parameters)

* Supported raster image formats: 'jpg', 'jpeg', 'png', 'gif', 'tiff', 'webp'
* Supported vector image formats: 'svg' - resize only

### Existing endpoints

* Get modified image:
```
curl -X GET --location "http://localhost/{imageName}?action={action}&height={height}&width={width}" 
```

Field | Type | Values       |
--- | --- |--------------| 
action | string | crop, resize |
height | int  | >0           |
width | int  | >0           |
