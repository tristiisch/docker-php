PROXY_SERVICE				:=	proxy
APPLICATION_SERVICE			:=	application

STACK_PROD					:= web
COMPOSE_PROD				:= ./.include/docker-compose.prod.yml
COMPOSE_PROD_DEMO			:= ./docker-compose.prod-demo.yml
ENV_PROD					:= .env.prod

PHP_CONF_DEFAULT_PATH		:= ./.include/php/configs/default

all: build networks up logs

build:
	@docker compose build --pull always

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

test-prod:
	@docker compose -f $(COMPOSE_PROD_DEMO) build --pull
	@docker compose -f $(COMPOSE_PROD_DEMO) up -d --remove-orphans --force-recreate

deploy-prod:
	@export $(shell grep -v '^#' $(ENV_PROD) | xargs) > /dev/null 2>&1 && docker stack deploy --detach=false -c $(COMPOSE_PROD) $(STACK_PROD)

update-php-conf-default:
	@for version in 5 7 8; do \
		docker run --rm --entrypoint=cat php:$$version-fpm-alpine /usr/local/etc/php/php.ini-production > $(PHP_CONF_DEFAULT_PATH)/php-$$version-prod.default.ini & \
		docker run --rm --entrypoint=cat php:$$version-fpm-alpine /usr/local/etc/php/php.ini-development > $(PHP_CONF_DEFAULT_PATH)/php-$$version-dev.default.ini & \
		docker run --rm --entrypoint=cat php:$$version-fpm-alpine /usr/local/etc/php-fpm.d/www.conf > $(PHP_CONF_DEFAULT_PATH)/fpm-$$version.default.ini & \
		docker run --rm --entrypoint=cat php:$$version-fpm-alpine /usr/local/etc/php-fpm.conf > $(PHP_CONF_DEFAULT_PATH)/fpm-$$version-global.default.ini & \
	done

.PHONY: logs
