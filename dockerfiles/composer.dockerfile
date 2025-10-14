FROM composer:2.8.12
WORKDIR /var/www/html
ENTRYPOINT [ "composer", "--ignore-platform-reqs" ]