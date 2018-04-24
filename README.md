
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
	* '**driver**' => 'mysql',  