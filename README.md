# Création d'un nouveau site Drupal dans la ferme

[Voir la procédure ici](./Nouveau-drupal.md)


# Installation Drupal avec Docker (multi site)  
* Créer un dossier sur son ordinateur ( par exemple : `D:/CARGO/WWW/drupal` )  
* Dans le dossier, entrer la ligne de commande suivante : `git clone https://github.com/PoleWebCargo/drupal.git`  
* Dupliquer et renommer le fichier `docker-compose.yml.dist` en `docker-compose.yml`
* Installer les dépendances : `docker-compose run --rm php composer install`
* Dupliquer et renommer le fichier `web/sites/*/settings.php.dist` en `web/sites/*/settings.php` :
	* '**database**' => '`{{ MYSQL_DATABASE }}`',  
	* '**username**' => '`{{ MYSQL_USER }}`',  
	* '**password**' => '`{{ MYSQL_PASSWORD }}`',  
	* '**prefix**' => '',  
	* '**host**' => '`{{ MYSQL_HOST }}`',  
	* '**port**' => '3306',  
	* '**namespace**' => 'Drupal\\Core\\Database\\Driver\\mysql',  
	* '**driver**' => 'mysql'

# Mettre à jour les médias et la base de données depuis la prépod

* Depuis le dossier /multisites/[site_name]:

* Lancer l'application : `docker-compose up -d`

* exécuter les commandes
    * 1/ `docker-compose run --rm php bash bin/synchfiles.sh`
        * Entrez le nom du site en local et en distant
        * Entrez le nom et le mot de passe de l'utilisateur de la base de données préprod
    * 2/ `docker-compose exec db /bin/bash /var/www/html/bin/synchbd.sh`
        * Entrez le nom de la base pour le site
        * Entrez les identifiantes de la base (locale) pour le site

* NB : si une erreur se produit "synchfiles non trouvé", c'est que vous n'êtes pas au bon endroit pour exécuter ce script. Il faut bien se placer dans /multisites/[site_name] pour exécuter le docker-compose du projet.

# Finaliser l'installation

* Dupliquer et renommer le fichier `web/sites/site.php.dist` en `web/sites/site.php` et changer les information avec les données de votre site

* changer `$settings['update_free_access'] = FALSE;` à `TRUE` dans settings.php

* accéder au site web `http://web.[nom du site].svdXpweb-stm.ressinfo.ad/core/install.php` et suivre les étapes

* changer à nouveau  `$settings['update_free_access'] = TRUE;` à `FALSE` dans settings.php

# Mise à jour de Drupal : 

Depuis le dossier /multisites/[site_name]:

* `composer outdated` : liste des modules qui ne sont plus à jours (entre VM et composer.lock)
* `composer update` : met à jour les dépendances avec les nouvelles versions dispo
* `composer install` : prend les version qui se trouve sur le composer.lock

# Mise à jour d'un module Drupal :

Depuis le dossier /multisites/[site_name]:

* `composer require 'NOMDUMODULE'`

## Déploiement

* `docker-compose run --rm bundle install` pour s’assurer d’avoir toutes les dépendances à jour
* `docker-compose run --rm bundle exec cap preproduction deploy` pour déployer en `preproduction`
* `docker-compose run --rm bundle exec cap -T` pour lister toutes les tâches disponibles
* `docker-compose run --rm bundle exec cap preproduction "symfony:console['cache:clear']"`

# Actions sur la base de données en local

Depuis le dossier /multisites/[site_name] :

Commande disponible :
    * `docker-compose exec db /bin/bash /var/www/html/bin/local-dump.sh`
        * Entrez le nom du site en local
        * Entrez l'action souhaitée (1, 2, etc)

# Accès à MailHog

Pour vérifer l'envoi des mails, se connecter à l'interface depuis sa VM : http://web.mailhog.{{ DEVENV }}.ressinfo.ad/ (exemple : http://web.mailhog.svd1pweb-stm.ressinfo.ad/)

# Résolution de problèmes:

## Base de donnée

### Corruption après un arrêt forcé

En cas d'arrêt forcé de mysql et si ce dernier ne rédémarre pas correctement, ajouter cette commande dans le 
`docker-compose.yml` du site en question dans le service DB
```bash
command: mysqld --tc-heuristic-recover=ROLLBACK
```

#Lancer une command Drupal

Depuis le dossier /multisites/[site_name]:

`php vendor/bin/drupal --uri=web.gersequipement.svd1pweb-stm.ressinfo.ad`

# Installation nouveau Drupal

Se baser sur ce qui a été fait pour les autres sites.

*a completer*
- ajouter des lignes dans le fichier deploy.rb pour gérer les dossiers en shared

## Configure XDEBUG

* Dans PhpStorm
	* Languages & Frameworks >  Php > Debug
		* Xdebug: Debug port à **9003**
		* Ne pas séléctionner:
		    * `Ignore External connections...`
			* `Force break at first line...` (les deux options)	    
	* Languages & Frameworks >  Php > Servers
		* Ajouter un nouveau serveur `drupal`
			* Host: localhost
			* Port: 80
			* Debugger: Xdebug
		* Cocher `Use Path mapping`
		    * A droite de la racine de votre projet (ex: `D:\CARGO\drupal`) ajoutez le chemin correspondant au chemin du projet dans le container php (`/var/www/html`)
	* En haut à droite de PhpStorm cliquez sur "Edit Configuration"
		* Ajouter un Php Remote Debug
			* Name: `drupal`
			* Sélectionner `Filter debug connection by IDE key`
			* Server: Sélectionner `drupal`
			* IDE key: `idekey`

Vous pouvez maintenant activer XDebug sur Phpstorm (le petit téléphonne)

# Activation debugger Twig, en local

Le debugger des templates Twig est *false* par défaut, pour l'activer en local :
* Décommenter le bloc suivant dans le fichier `web/sites/*/settings.php` :
```php
if (file_exists($app_root . '/' . $site_path . '/settings.local.php')) {'   
   include $app_root . '/' . $site_path . '/settings.local.php';
}
```
* Dupliquer et renommer le fichier `web/sites/example.settings.local.php` en `web/sites/*/settings.local.php` et ne garder **<ins>que</ins>** les lignes suivantes :
```php
<?php

/**
 * Enable local development services.
 */
$settings['container_yamls'][] = DRUPAL_ROOT . '/sites/development.services.yml';
```
* *Pour plus de détails sur la gestion du cache : https://www.drupal.org/node/2598914*