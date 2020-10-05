#!/bin/bash
db_preprod="db_preprod"
db_local_host="localhost"
echo "Quelle est la nom de la base pour le site en local ? "
read db_local_preprod
if [[ "$db_local_preprod" != "" ]]
then
db_local_username="root"
db_local_password="root"
echo "charger les données dans la base $db_local_preprod"
mysql -h$db_local_host -u$db_local_username -p$db_local_password $db_local_preprod < /var/www/html/$db_preprod.sql
rm -R /var/www/html/$db_preprod.sql
echo "fin"
fi