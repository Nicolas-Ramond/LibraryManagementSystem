#!/bin/bash
# Le but de notre fichier fixtures est de peupler la bdd mysql de docker

#On supprime tous nos containers et les volumes associés
#docker-compose stop && docker-compose rm -f

#docker-compose exec php php /usr/local/apache2/htdocs/bin/console --force doctrine:database:drop
#
#docker-compose exec php php /usr/local/apache2/htdocs/bin/console doctrine:database:create
#
#docker-compose exec php php /usr/local/apache2/htdocs/bin/console doctrine:migration:diff
#
#docker-compose exec php php /usr/local/apache2/htdocs/bin/console doctrine:migration:migrate
#
#docker-compose exec php php /usr/local/apache2/htdocs/bin/console doctrine:fixtures:load
