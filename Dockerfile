# Runs PHP's built-in server instead of the platform's nginx image, whose
# entrypoint tries to write /etc/nginx/nginx.conf and crashes on a read-only filesystem.
FROM php:8.4-cli-alpine

WORKDIR /app
COPY . /app

ENV PORT=8080
EXPOSE 8080
USER www-data

CMD ["sh", "-c", "exec php -S 0.0.0.0:${PORT:-8080}"]
