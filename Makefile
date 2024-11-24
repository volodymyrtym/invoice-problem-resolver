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
	@docker-compose exec php composer install
	$(MAKE) doctrine-migrate
	@echo "Environment is ready for development!"

down: ## down app containers
	@docker compose down

build: down setup-env compare-env ## build app with cache
	@docker compose build

build-no-cache: down setup-env compare-env  ## build app without cache
	@docker compose build --no-cache

rebuild: build up ## rebuild app with cache

rebuild-no-cache: build-no-cache up ## rebuild app with cache

compare-env:
	@diff <(grep -v '^#' .env | grep -v '^\s*$$' | sort) <(grep -v '^#' .env.local | grep -v '^\s*$$' | sort) || (echo "Environment files differ!" && exit 1)

setup-env:
	@test -f .env.local || cp .env .env.local

# >>> backend
symfony-console: ## backend. run symfony console
	@docker compose exec php "php bin/console $(filter-out $@,$(MAKECMDGOALS))"

composer: ## backend. run composer
	@docker compose exec "composer $(filter-out $@,$(MAKECMDGOALS))"

doctrine-migrate: ## backend. doctrine migrate
	@docker compose exec php /bin/bash -c "php bin/console doctrine:migration:migrate --allow-no-migration -n"

doctrine-diff: ## backend. doctrine diff
	@docker compose exec php /bin/bash -c "php bin/console doctrine:migration:diff"

doctrine-cache-clear: ## backend. doctrine cache clear
	@docker compose exec php /bin/bash -c "php bin/console doctrine:cache:clear-result"
	@docker compose exec php /bin/bash -c "php bin/console doctrine:cache:clear-query"
	@docker compose exec php /bin/bash -c "php bin/console doctrine:cache:clear-metadata"
# <<< backend
