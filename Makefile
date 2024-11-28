SHELL := /bin/bash

default: help

help:
	@echo "Available commands:"
	@echo "Docker Commands:"
	@grep -E '^(up|down|build|build-no-cache|rebuild|rebuild-no-cache):.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-15s %s\n", $$1, $$2}'
	@echo "----------------------"
	@echo "Backend Commands:"
	@grep -E '^(symfony-console|composer|doctrine-migrate|doctrine-diff|doctrine-cache-clear):.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-15s %s\n", $$1, $$2}'

up: down compare-env ## up app containers for dev env
	@docker compose up -d
	$(MAKE) website-node-install
	$(MAKE) fix-permissions
	@docker-compose exec php composer install
	$(MAKE) doctrine-migrate
	$(MAKE) website-node-dev
	@echo "Environment is ready for development!"

fix-permissions:
	@sudo chown -R $(shell id -u):$(shell id -g) ./website

down: ## down app containers
	@docker compose down

build: down setup-env compare-env ## build app with cache
	@docker compose build

build-no-cache: down setup-env compare-env  ## build app without cache
	@docker compose build --no-cache

rebuild: build up ## rebuild app with cache

rebuild-no-cache: build-no-cache up ## rebuild app with cache

compare-env:
	@diff <(grep -v '^#' .env | grep -v '^\s*$$' | cut -d '=' -f 1 | sort) \
	      <(grep -v '^#' .env.local | grep -v '^\s*$$' | cut -d '=' -f 1 | sort) \
	|| (echo "Environment files differ!" && exit 1)

setup-env:
	@test -f .env.local || cp .env .env.local
	@test -f ./backend/.env.local || cp ./backend/.env ./backend/.env.local
	@test -f ./website/.env.local || cp ./website/.env ./website/.env.local

# >>> backend
symfony-console: ## backend. run symfony console
	@docker compose exec php php bin/console $(filter-out $@,$(MAKECMDGOALS))

composer: ## backend. run composer
	@docker compose exec php composer $(filter-out $@,$(MAKECMDGOALS))

doctrine-migrate: ## backend. doctrine migrate
	@docker compose exec php /bin/bash -c "php bin/console doctrine:migration:migrate --allow-no-migration -n"

doctrine-diff: ## backend. doctrine diff
	@docker compose exec php /bin/bash -c "php bin/console doctrine:migration:diff"

doctrine-cache-clear: ## backend. doctrine cache clear
	@docker compose exec php /bin/bash -c "php bin/console doctrine:cache:clear-result"
	@docker compose exec php /bin/bash -c "php bin/console doctrine:cache:clear-query"
	@docker compose exec php /bin/bash -c "php bin/console doctrine:cache:clear-metadata"
# <<< backend

# > website
website-node-install:
	@docker-compose exec -d website sh -c "npm install"

website-node-dev:
	@docker-compose exec -d website sh -c "npm run build"
	@docker-compose exec website sh -c "npm run start-dev"
#< website
