#!/bin/bash
echo "Quel environnement ? [production || preproduction] ? "
read env
if [[ "$env" == "production" ]]
then
    hostname="sitedrupal_prod"
    envurl="sitevitrine"
else
    hostname="sitedrupal_preprod"
    envurl="preprod-sitevitrine"
    env="preproduction"
fi

echo "Saisir le nom du site"
read SITENAME
if [[ "$SITENAME" != "" ]]
then
    cp -r  docker/deployment/.ssh/ ~/.ssh/
    chmod -R 600 ~/.ssh/
    rsync -avzL -e "ssh -p 22922" $hostname@$envurl.cargo-webproject.com:deployment/$env/shared/web/sites/$SITENAME/files/ web/sites/$SITENAME/files
    echo deployment/$env/shared/web/sites/$SITENAME/files/ web/sites/$SITENAME/files

    db_host="localhost"
    echo "Quelle est la nom de la base pour le site $SITENAME ($env) ? "
    read db_name
    if [[ "$db_name" != "" ]]
    then
        echo "Quel compte utilisateur bd pour la base $db_name ($env) ? "
        read username
        if [[ "$username" != "" ]]
        then
            echo "Mdp table $db_name ($env) ? "
            read password
            if [[ "$password" != "" ]]
            then
                echo "mysql dump de la base $db_name $username $password en cours ..."
                ssh -n -p 22922 $hostname@$envurl.cargo-webproject.com "mysqldump -u $username -p$password $db_name">db_dump.sql
                echo "fin du dump"
            fi
        fi
    fi
else
    echo "Il manque une des informations de dossier local ou distant"
fi