# Репозиторий для сдачи ДЗ по курсу Symfony

docker-compose exec php-fpm php -v

docker-compose run --rm php-cli php -v

docker-compose run --rm php-cli composer install

docker-compose run --rm php-cli bin/console make:entity 

composer require zenstruck/foundry --dev
symfony console make:factory NAME


docker-compose run --rm php-cli bin/console doctrine:fixtures:load -n
docker-compose run --rm php-cli bin/console doctrine:query:sql "SELECT * FROM filter;"
