FROM node:22

RUN apt-get update && apt-get install -y ca-certificates apt-transport-https lsb-release curl gnupg2 \
    && curl -sSL https://packages.sury.org/php/apt.gpg | gpg --dearmor -o /usr/share/keyrings/deb.sury.org-php.gpg \
    && echo "deb [signed-by=/usr/share/keyrings/deb.sury.org-php.gpg] https://packages.sury.org/php/ $(lsb_release -sc) main" > /etc/apt/sources.list.d/php.list \
    && apt-get update \
    && apt-get install -y php8.4-cli \
    && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www