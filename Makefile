init: docker-down-clear docker-pull docker-build \
 		docker-up composer-install doctrine_renew-migration doctrine-migrate


up: docker-up
down: docker-down
restart: down up
db-renew: doctrine_renew-migration doctrine-migrate

seed: doctrine-fixtures-load


docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-down-clear:
	docker-compose down -v --remove-orphans

docker-pull:
	docker-compose pull

docker-build:
	docker-compose build


composer-install:
	docker-compose run --rm php-cli composer install

doctrine-migrate:
	docker-compose run --rm php-cli bin/console doctrine:migrations:migrate -n

doctrine_renew-migration:
	#rm -v -f migrations/Ver*
	#docker-compose run --rm php-cli rm -fv /app/migrations/Ver*
	docker-compose run --rm php-cli bin/console doctrine:database:drop --force
	docker-compose run --rm php-cli bin/console doctrine:database:create --env=dev
	#docker-compose run --rm php-cli bin/console make:migration -n

doctrine-fixtures-load:
	docker-compose run --rm php-cli bin/console doctrine:fixtures:load -n
