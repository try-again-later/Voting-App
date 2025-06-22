FROM composer:2.2.25 as php_builder

WORKDIR /var/www
COPY . /var/www
RUN composer install


FROM debian:bookworm as builder

RUN mkdir -p /var/www/vendor/livewire/livewire/dist
COPY --from=php_builder /var/www/vendor/livewire/livewire/dist/livewire.esm.js /var/www/vendor/livewire/livewire/dist/

RUN \
  apt-get update && \
  apt-get install -y --no-install-recommends \
    curl \
    nodejs \
    npm \
  && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

WORKDIR /var/www
COPY . /var/www
RUN \
  npm install && \
  npm run build


FROM nginx:1.27.5-alpine

COPY ./docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY --from=builder /var/www/public /var/www/public

WORKDIR /var/www/public
EXPOSE 80
CMD ["nginx", "-g", "daemon off;"]
