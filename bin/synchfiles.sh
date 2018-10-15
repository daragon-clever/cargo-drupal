#!/bin/bash
DIRLOCAL=$1
DIRDISTANT=$2



if [[ "$DIRLOCAL" != "" && "$DIRDISTANT" != "" ]]
then
    cp -r  docker/deployment/.ssh/ ~/.ssh/
    chmod -R 600 ~/.ssh/
    rsync -avzL -e "ssh -p 22922" sitedrupal_preprod@preprod-sitevitrine.cargo-webproject.com:deployment/preproduction/shared/web/sites/$DIRDISTANT/files/ web/media

    echo deployment/preproduction/shared/web/sites/$DIRDISTANT/files/ web/sites/$DIRLOCAL/files

    db_host="localhost"

    echo "Quelle est la nom de la base pour le site $DIRDISTANT ? "
    read db_preprod
    if [[ "$db_preprod" != "" ]]
    then
        echo "Quel compte utilisateur bd pour la base $db_preprod ? "
        read username
        if [[ "$username" != "" ]]
        then
            echo "Mdp table $db_preprod ? "
            read password
            if [[ "$password" != "" ]]
            then
                echo "mysql dump de la base $db_preprod $username $password"
                ssh -n -p 22922 sitedrupal_preprod@preprod-sitevitrine.cargo-webproject.com "mysqldump -u $username -p$password $db_preprod">db_preprod.sql
                echo "fin du dump"
            fi
        fi
    fi
else

echo "Il manque une des informations de dossier local ou distant"

fi

