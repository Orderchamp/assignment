#!/usr/bin/env bash
docker-compose up -d --build

docker exec -it arm_app bash -c "cd /var/www && composer install --no-interaction"

docker-compose exec arm_app php artisan queue:table
docker-compose exec arm_app php artisan migrate
docker-compose exec arm_app php artisan db:seed
