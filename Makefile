.PHONY: all setup-dirs docker-up restart-pgsql composer-install set-permissions migrate create-tests-db

up: setup-dirs docker-up restart-pgsql composer-install set-permissions migrate create-tests-db

setup-dirs:
	mkdir -p pgsql

docker-up:
	docker compose up -d --build

restart-pgsql:
	docker compose restart pgsql

composer-install:
	docker compose exec php composer install

set-permissions:
	docker compose exec php chown -R www-data:www-data /app

migrate:
	docker compose exec php php bin/console doctrine:migrations:migrate --no-interaction

create-tests-db:
	docker compose exec php php bin/console doctrine:database:create --env=test

test:
	docker compose exec php php vendor/bin/codecept run -c codeception.yml
