#!/bin/bash

type=$1

if [[ $type == 'up' ]]; then
 cd ${PWD}/../laradock && docker-compose --env-file .env.laravel-inertia-react up -d mysql php-fpm phpmyadmin nginx redis redis-webui laravel-echo-server
elif [[ $type == 'exec' ]]; then
 cd ${PWD}/../laradock && docker-compose --env-file .env.laravel-inertia-react exec workspace bash
elif [[ $type == 'stop' ]]; then
 docker stop $(docker ps -aq)
 # cd ${PWD}/../laradock && docker-compose --env-file .env.laravel-inertia-react down mysql php-fpm phpmyadmin nginx redis
elif [[ $type == 'rebuild' ]]; then
 cd ${PWD}/../laradock && docker-compose --env-file .env.laravel-inertia-react down mysql php-fpm phpmyadmin nginx redis redis-webui laravel-echo-server
 cd ${PWD}/../laradock && docker-compose --env-file .env.laravel-inertia-react build mysql php-fpm phpmyadmin nginx redis redis-webui laravel-echo-server --no-cache
 cd ${PWD}/../laradock && docker-compose --env-file .env.laravel-inertia-react up -d mysql php-fpm phpmyadmin nginx redis redis-webui laravel-echo-server
fi

