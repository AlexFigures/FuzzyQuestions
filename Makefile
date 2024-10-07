.PHONY: all setup-dirs docker-up restart-pgsql composer-install set-permissions

up: setup-dirs docker-up restart-pgsql composer-install set-permissions

setup-dirs:
	mkdir -p pgsql
	sudo chown -R postgres:postgres pgsql

docker-up:
	docker compose up -d --build

restart-pgsql:
	docker compose restart pgsql

composer-install:
	docker compose exec php composer install

set-permissions:
	docker compose exec php chown -R www-data:www-data /app
