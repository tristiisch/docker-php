ARG PHP_MAJOR="8"
ARG PHP_PRODUCTION_IMAGE=ghcr.io/tristiisch/php-fpm:${PHP_MAJOR}-production
ARG PHP_DEVELOPMENT_IMAGE=ghcr.io/tristiisch/php-fpm:${PHP_MAJOR}-development
ARG NGINX_IMAGE=ghcr.io/tristiisch/nginx-php:latest

# <=========================> APP production <=========================>
FROM ${PHP_PRODUCTION_IMAGE} AS app_production

# SRCS
COPY --chown=root:app --chmod=550 ./srcs ./

# <=========================> APP development <=========================>
FROM ${PHP_DEVELOPMENT_IMAGE} AS app_development

# SRCS
COPY --chown=root:app --chmod=550 ./srcs ./

# <=========================> Proxy <=========================>
FROM ${NGINX_IMAGE} AS proxy

COPY --chown=root:nginx --chmod=550 ./srcs ./
