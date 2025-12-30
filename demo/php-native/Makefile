PROXY_SERVICE				= proxy
APPLICATION_SERVICE			= application

STACK_PROD					= web
COMPOSE_PROD				= ./.include/docker-compose.prod.yml
# COMPOSE_PROD_DEMO			= ./docker-compose.prod-demo.yml -f ./docker-compose.prod-demo.override.yml
ENV_PROD					= .env.prod

-include Makefile.override

all: build networks up logs

build:
	@docker compose build --pull

networks:
	@docker network create metrics 2> /dev/null || true

up:
	@docker compose up -d --remove-orphans

up-f:
	@docker compose up -d --remove-orphans --force-recreate

logs:
	@docker compose logs -f -n 100

exec-nginx:
	@docker compose exec $(PROXY_SERVICE) sh

exec-php:
	@docker compose exec $(APPLICATION_SERVICE) sh

down:
	@docker compose down

down-v:
	@docker compose down -v

# test-prod:
# 	@docker compose -f $(COMPOSE_PROD_DEMO) build --pull
# 	@docker compose -f $(COMPOSE_PROD_DEMO) up -d --remove-orphans --force-recreate

deploy-prod:
	@export $(shell grep -v '^#' $(ENV_PROD) | xargs) > /dev/null 2>&1 && docker stack deploy --detach=false -c $(COMPOSE_PROD) $(STACK_PROD)

.PHONY: logs
