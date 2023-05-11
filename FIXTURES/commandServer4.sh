#!/bin/bash

docker-compose exec php php /usr/local/apache2/htdocs/bin/console doctrine:fixtures:load