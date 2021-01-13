#!/bin/bash
echo "Quelle est la nom de la base en local/sur la VM ? "
read db_name
if [[ "$db_name" != "" ]]
then
    echo "Quelle est l'action a effectué ? "
    echo "1- Dump de la base en local"
    echo "2- Appliqué un dump sur la base en local"
    read action
    if [[ "$action" != "" ]]
    then
        case $action in
            1)
                filename=$(date +"%Y_%m_%d")_$db_name
                echo "Dump de la base $db_name en cours ..."
                mysqldump --user=root --password=root --lock-tables --databases $db_name > /var/www/html/$filename.sql
                echo "fin du dump"
            ;;
            2)
                echo "Quelle est la nom du dump à appliquer ? "
                read dump_name
                if [[ "$dump_name" != "" ]]
                then
                    echo "Application du dump $dump_name pour la base $db_name en cours ..."
                    mysql -hlocalhost -uroot -proot $db_name < /var/www/html/$dump_name
                    echo "dump appliqué"
                fi
            ;;
        esac
    fi
fi