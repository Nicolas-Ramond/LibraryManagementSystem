#!/bin/bash
## --user=XXXXXX --password=XXXXXX *may* not be necessary if run as root or you have unsecured DBs but
##   using them makes this script a lot more portable.  Thanks @billkarwin
RESULT=`docker-compose exec db mysqlshow --user=root | grep -v Wildcard | grep -o library`
if [ "$RESULT" == "library" ]; then
    docker-compose exec php php /usr/local/apache2/htdocs/bin/console --force doctrine:database:drop
else
    echo "Nothing to drop, going on next step"
fi