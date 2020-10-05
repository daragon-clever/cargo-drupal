#!/bin/bash
echo "Quelle environnement ? [production || preproduction] ? "
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

echo "Saisir le nom du site en local"
read DIRLOCAL

echo "Saisir le nom du site en distant ($env)"
read DIRDISTANT

if [[ "$DIRLOCAL" != "" && "$DIRDISTANT" != "" ]]
then
    cp -r  docker/deployment/.ssh/ ~/.ssh/
    chmod -R 600 ~/.ssh/
    rsync -avzL -e "ssh -p 22922" $hostname@$envurl.cargo-webproject.com:deployment/$env/shared/web/sites/$DIRDISTANT/files/ web/sites/$DIRLOCAL/files
    echo deployment/$env/shared/web/sites/$DIRDISTANT/files/ web/sites/$DIRLOCAL/files
    db_host="localhost"
    echo "Quelle est la nom de la base pour le site $DIRDISTANT (preprod) ? "
    read db_preprod
    if [[ "$db_preprod" != "" ]]
    then
        echo "Quel compte utilisateur bd pour la base $db_preprod (preprod) ? "
        read username
        if [[ "$username" != "" ]]
        then
            echo "Mdp table $db_preprod (preprod) ? "
            read password
            if [[ "$password" != "" ]]
            then
                echo "mysql dump de la base $db_preprod $username $password en cours ..."
                ssh -n -p 22922 $hostname@$envurl.cargo-webproject.com "mysqldump -u $username -p$password $db_preprod">db_preprod.sql
                echo "fin du dump"
            fi
        fi
    fi
else
    echo "Il manque une des informations de dossier local ou distant"
fi