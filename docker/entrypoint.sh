#!/bin/sh
set -e
# Переходим в директорию app
cd app
# Если есть файл .firstrun_php , то команда  composer --no-interaction install не выполняется
if [ ! -f '.firstrun_php' ]; then
    export COMPOSER_ALLOW_SUPERUSER=1
    touch '.firstrun_php'
    echo "Running composer install"
    composer --no-interaction install
    php bin/console lexik:jwt:generate-keypair --skip-if-exists
fi
# команда, которая начинает слушать запросы на порту 8000
php -S 0.0.0.0:$PORT $PUBLIC_DIR/$INDEX_FILE

exec "$@"