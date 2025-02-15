FROM nginx:1-alpine AS default
ARG USER="nginx"
EXPOSE 80/tcp 443/tcp

# Cache
RUN mkdir -p /var/cache/nginx \
	&& chown root:$USER -R /var/cache/nginx \
	&& chmod 770 -R /var/cache/nginx

# Config
COPY --chown=root:$USER --chmod=550 ./.include/nginx/configs/nginx.conf /etc/nginx/nginx.conf
COPY --chown=root:$USER --chmod=550 ./.include/nginx/configs/status.conf /etc/nginx/status.conf

WORKDIR /var/www

# Errors pages
RUN mkdir -p ./errors \
	&& chown root:$USER -R ./errors \
	&& chmod 550 -R ./errors \
	&& mkdir -p ./html/errors \
	&& chown root:$USER -R ./html/errors\
	&& chmod 550 -R ./html/errors
COPY --chown=root:$USER --chmod=550 ./.include/nginx/errors/*.html ./errors
COPY --chown=root:$USER --chmod=550 ./.include/nginx/errors/*.css ./html/errors

# Assets
COPY --chown=root:$USER --chmod=550 ./assets ./html/assets

HEALTHCHECK --interval=10s --timeout=3s --retries=3 \
  CMD curl --fail --location --insecure http://localhost/status_nginx || exit 1

# Validate configuration
RUN nginx -t

# USER $USER

CMD ["nginx", "-g", "daemon off;"]
