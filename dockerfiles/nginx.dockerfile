FROM nginx:1.28-alpine
WORKDIR /etc/nginx/conf.d
COPY nginx/nginx.conf .

WORKDIR /var/www/html
COPY . .