#!/bin/bash
composer install
exec docker-php-entrypoint "$@"
