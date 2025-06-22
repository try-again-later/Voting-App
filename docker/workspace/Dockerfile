FROM php:8.4-cli

ARG UID=1000
ARG GID=1000
ARG NODE_VERSION=22.0.0
ARG PROXY

RUN \
  apt-get update && \
  apt-get install -y --no-install-recommends \
    curl \
    unzip \
    libpq-dev \
    libsqlite3-dev \
    libonig-dev \
    libssl-dev \
    libxml2-dev \
    libcurl4-openssl-dev \
    libicu-dev \
    libzip-dev \
    zlib1g \
    zlib1g-dev \
  && \
  docker-php-ext-install -j$(nproc) \
    mbstring \
    pdo_sqlite \
    pdo_pgsql \
    pgsql \
    opcache \
    intl \
    zip \
    bcmath \
    soap \
  && \
  apt-get autoremove -y && \
  apt-get clean && \
  rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

RUN \
  if getent group ${GID}; then \
    useradd -m -u ${UID} -g ${GID} -s /bin/bash www; \
  else \
    groupadd -g ${GID} www && \
    useradd -m -u ${UID} -g www -s /bin/bash www; \
  fi \
  && \
  usermod -aG sudo www && \
  echo 'www ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers

USER www

RUN \
  export NVM_DIR="$HOME/.nvm" && \
  curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.40.0/install.sh | bash && \
  [ -s "$NVM_DIR/nvm.sh" ] && . "$NVM_DIR/nvm.sh" && \
  nvm install ${NODE_VERSION} && \
  nvm alias default ${NODE_VERSION} && \
  nvm use default
RUN \
  echo 'export NVM_DIR="$HOME/.nvm"' >> /home/www/.bashrc && \
  echo '[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"' >> /home/www/.bashrc && \
  echo '[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"' >> /home/www/.bashrc

WORKDIR /var/www
ENTRYPOINT []
CMD ["bash"]
