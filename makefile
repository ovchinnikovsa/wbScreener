run:
	docker-compose up -d

up:
	docker-compose up

stop:
	docker-compose down

build:
	docker-compose build

composer-install:
	docker-compose exec --user root app composer install

composer-autoload:
	docker-compose exec --user root app composer dump-autoload