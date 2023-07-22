### Architecture

This repository implements Clean architecture (Domain, Application, Infrastructure and UI Layers) and Domain Driven Design (Entities, Repositories, Application Services...) with applying SOLID principles.

### System requirements
- Docker Engine installed (see [Docker Engine overview](https://docs.docker.com/install/))
- Docker Compose installed (see [Install Docker Compose](https://docs.docker.com/compose/install/))

### Installation

The project is dockerized and configured to work with docker compose
- `docker compose up -d`
- `docker compose exec php-fpm sh composer install` 

#### Other commands:

Run tests
- `docker compose exec php-fpm	./vendor/bin/phpunit`

### Existing endpoints

Get modified image:
```
curl -X GET --location "http://localhost/{imageName}?action={action}&height={height}&width={width}" 
```
