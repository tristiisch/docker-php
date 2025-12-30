ARG USER="nginx"

FROM nginx:1-alpine AS default
ARG USER
EXPOSE 80/tcp 443/tcp

# Cache
RUN mkdir -p /var/cache/nginx \
	&& chown root:$USER -R /var/cache/nginx \
	&& chmod 770 -R /var/cache/nginx

# Config
COPY --chown=root:$USER --chmod=440 ./configs/nginx.conf /etc/nginx/nginx.conf

WORKDIR /var/www/

# Errors pages
RUN mkdir -p ./errors \
	&& chown root:$USER -R ./errors \
	&& chmod 550 -R ./errors
COPY --chown=root:$USER --chmod=440 ./errors/* ./errors

WORKDIR /var/www/html

HEALTHCHECK --interval=15s --timeout=5s --retries=5 \
  CMD curl --fail --location http://localhost/ping_nginx || exit 1

# Validate configuration
RUN nginx -t && rm -rf /tmp/nginx.pid

USER $USER

CMD ["nginx", "-g", "daemon off;"]
