#!/bin/bash
dump_file="db_dump"
db_local_host="localhost"
db_local_username="root"
db_local_password="root"

echo "Quelle est la nom de la base pour le site en local ? "
read db_local
if [[ "$db_local" != "" ]]
then
    echo "Chargement des données dans la base $db_local (local)"
    mysql -h$db_local_host -u$db_local_username -p$db_local_password $db_local < /var/www/html/$dump_file.sql
    rm -R /var/www/html/$dump_file.sql
    echo "fin"
fi