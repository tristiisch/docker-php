NGINX_IMAGE_NAME			= nginx:local
PHP_IMAGE_NAME				= php:local
PHP_CONF_DEFAULT_PATH		= ./php/configs/default


all:
	@$(MAKE) -j2 nginx php

nginx:
	@docker build \
		-f ./nginx/Dockerfile \
		--target default \
		-t $(NGINX_IMAGE_NAME) \
		--pull \
		./nginx

php:
	@$(MAKE) -j2 php-8-production php-8-development
	@$(MAKE) -j2 php-7-production php-7-development
	@$(MAKE) -j2 php-5-production php-5-development

php-8-production:
	@$(MAKE) php-template \
		PHP_MAJOR=8 \
		PHP_TARGET_ENV=production

php-8-development:
	@$(MAKE) php-template \
		PHP_MAJOR=8 \
		PHP_TARGET_ENV=development

php-7-production:
	@$(MAKE) php-template \
		PHP_MAJOR=7 \
		PHP_TARGET_ENV=production

php-7-development:
	@$(MAKE) php-template \
		PHP_MAJOR=7 \
		PHP_TARGET_ENV=development

php-5-production:
	@$(MAKE) php-template \
		PHP_MAJOR=7 \
		PHP_TARGET_ENV=production

php-5-development:
	@$(MAKE) php-template \
		PHP_MAJOR=7 \
		PHP_TARGET_ENV=development

php-template:
	@docker build \
		-f ./php/Dockerfile \
		--target base_$(PHP_TARGET_ENV) \
		-t $(PHP_IMAGE_NAME)-$(PHP_MAJOR)-$(PHP_TARGET_ENV) \
		--pull \
		--build-arg PHP_MAJOR=$(PHP_MAJOR) \
		./php

php-update-conf-default:
	@for version in 5 7 8; do \
		docker run --rm --entrypoint=cat php:$$version-fpm-alpine /usr/local/etc/php/php.ini-production > $(PHP_CONF_DEFAULT_PATH)/php-$$version-prod.default.ini & \
		docker run --rm --entrypoint=cat php:$$version-fpm-alpine /usr/local/etc/php/php.ini-development > $(PHP_CONF_DEFAULT_PATH)/php-$$version-dev.default.ini & \
		docker run --rm --entrypoint=cat php:$$version-fpm-alpine /usr/local/etc/php-fpm.d/www.conf > $(PHP_CONF_DEFAULT_PATH)/fpm-$$version.default.ini & \
		docker run --rm --entrypoint=cat php:$$version-fpm-alpine /usr/local/etc/php-fpm.conf > $(PHP_CONF_DEFAULT_PATH)/fpm-$$version-global.default.ini & \
	done

.PHONY: nginx php
