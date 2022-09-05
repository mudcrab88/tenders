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

cache-clear:
	@docker-compose exec -T app php bin/console cache:clear

composer-install:
	@docker-compose exec -T app composer install -d /app --ignore-platform-reqs

load-tenders:
	@docker-compose exec -T app php bin/console app:load-tenders test_task_data.csv

