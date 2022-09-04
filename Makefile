build:
	@docker-compose build

up:
	@docker-compose up -d

down:
	@docker-compose down

bash:
	@docker-compose exec app /bin/bash

composer-update:
	@docker-compose exec -T app composer update -d /app

migrate:
	@docker-compose exec -T app php bin/console doctrine:migrations:migrate

validate-schema:
	@docker-compose exec -T app php bin/console doctrine:schema:validate

cache-clear:
	@docker-compose exec -T app php bin/console cache:clear

