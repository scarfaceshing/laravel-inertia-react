#!/bin/bash

container="mysql php-fpm phpmyadmin nginx redis redis-webui laravel-echo-server"
type=$1

if [[ $type == 'up' ]]; then
 cd ${PWD}/../laradock && sudo docker-compose --env-file .env.laravel-inertia-react up -d $container
 cd ${PWD}/../laradock && sudo docker-compose --env-file .env.laravel-inertia-react exec workspace bash
elif [[ $type == 'exec' ]]; then
 cd ${PWD}/../laradock && sudo  docker-compose --env-file .env.laravel-inertia-react exec workspace bash
elif [[ $type == 'stop' ]]; then
 sudo docker stop $(sudo docker ps -aq)
 # cd ${PWD}/../laradock && docker-compose --env-file .env.laravel-inertia-react down mysql php-fpm phpmyadmin nginx redis
elif [[ $type == 'rebuild' ]]; then
 cd ${PWD}/../laradock && sudo docker-compose --env-file .env.laravel-inertia-react down $container
 cd ${PWD}/../laradock && sudo docker-compose --env-file .env.laravel-inertia-react build $container --no-cache
 cd ${PWD}/../laradock && sudo docker-compose --env-file .env.laravel-inertia-react up -d $container
fi
