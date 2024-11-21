SHELL := /bin/bash

default: help

help:
	@echo "Available commands:"
	@echo "Docker Commands:"
	@grep -E '^(up-dev|down|build|build-no-cache|rebuild|rebuild-no-cache):.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-15s %s\n", $$1, $$2}'
	@echo "----------------------"
	@echo "Backend Commands:"
	@grep -E '^(symfony-console|composer):.*?## .*$$' Makefile | sort | awk 'BEGIN {FS = ":.*?## "}; {printf "  %-15s %s\n", $$1, $$2}'

up-dev: down compare-env ## up app containers for dev env
	@docker compose -f docker-compose.yml -f docker-compose-dev.yml up -d
	@docker-compose exec php composer install
	@echo "Environment is ready for development!"

down: ## down app containers
	@docker compose down

build: down setup-env compare-env ## build app with cache
	@docker compose build

build-no-cache: down setup-env compare-env  ## build app without cache
	@docker compose build --no-cache

rebuild: build up-dev ## rebuild app with cache

rebuild-no-cache: build-no-cache up-dev ## rebuild app with cache

compare-env:
	@diff <(grep -v '^#' .env | grep -v '^\s*$$' | sort) <(grep -v '^#' .env.local | grep -v '^\s*$$' | sort) || (echo "Environment files differ!" && exit 1)

setup-env:
	@test -f .env.local || cp .env .env.local

# >>> backend
symfony-console: ## backend. run symfony console
	@docker-compose exec php php bin/console $(filter-out $@,$(MAKECMDGOALS))

composer: ## backend. run composer
	docker-compose exec php composer $(filter-out $@,$(MAKECMDGOALS))

# <<< backend
