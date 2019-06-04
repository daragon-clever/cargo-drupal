
# Installation Drupal avec Docker (multi site)  
* Créer un dossier sur son ordinateur ( par exemple : `D:/CARGO/WWW/drupal` )  
* Dans le dossier, entrer la ligne de commande suivante : `git clone https://github.com/PoleWebCargo/drupal.git`  
* Dupliquer et renommer le fichier `docker-compose.yml.dist` en `docker-compose.yml` :
   * Remplacer `{{ CHEMIN_LOCAL }}` par le dossier de travail **dans Docker**
   * Remplacer `{{ MYSQL_DATABASE }}`, `{{ MYSQL_USER }}` et `{{ MYSQL_PASSWORD }}`
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
Depuis la racine du projet, exécuter la commande :
1. `docker-compose run --rm php bash bin/synchfiles.sh`
    * Entrez le nom du site en local et en distant
    * Entrez le nom et le mot de passe de l'utilisateur de la base de données préprod
2. `docker-compose exec db /bin/bash /var/www/html/bin/synchbd.sh`
	
# Mise à jour de Drupal : 
* `docker-compose run --rm php composer outdated`
* `docker-compose run --rm php composer update`

# Mise à jour d'un module Drupal :
* `$ docker-compose run --rm php composer require 'NOMDUMODULE'`

## Déploiement

* `docker-compose run --rm bundle install` pour s’assurer d’avoir toutes les dépendances à jour
* `docker-compose run --rm bundle exec cap preproduction deploy` pour déployer en `preproduction`
* `docker-compose run --rm bundle exec cap -T` pour lister toutes les tâches disponibles
* `docker-compose run --rm bundle exec cap preproduction "symfony:console['cache:clear']"`
