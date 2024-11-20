up-dev:
	@docker compose -f docker-compose.yml -f docker-compose-dev.yml up -d

down:
	@docker compose down

build: down
	@docker compose build

build-no-cache: down
	@docker compose build --no-cache

rebuild: down build up-dev

rebuild-no-cache: down build-no-cache up-dev


