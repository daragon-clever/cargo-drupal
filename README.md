# DRUPAL

Ce document décris l'environnement de développement des équipes Cargo, les autres intervenants doivent se réferer à la documentation [CleverAge](./cleverage/README.md)

## Installation du projet

**Pré-requis :**

- Git (GitKraken)
- Logiciel développement (PhpStorm)
- Ligne de commande (Terminus, Termius, etc)
- Docker (sur VM)
- Composer (sur VM)
- Fichier `/multisites/{{ SITENAME }}/.rvmc` et `/bin/cli-setup.sh` à mettre au format LF

**A remplacer :** avec ses propres informations

- {{ LOCATION }} correspond au chemin local des fichiers du projet
- {{ VM }} correspond au numéro de la VM
- {{ SITENAME }} correspond au projet que vous souhaitez actuellement installer

Lancer toutes les commandes suivantes depuis le dossier : `multisites/[SITENAME]`

### 1. Clôner le dépôt en local :

- via ligne de commande : `git clone https://github.com/PoleWebCargo/drupal.git`
- via Gitkraken : **"Clone a repo"**

Il n'y a pas besoin de cloner le dépôt pour chaque site.

### 2. Ouvrir le projet :

- Dupliquer le fichier `/docker-compose.yml.dist` en `/docker-compose.yml`.
- Dupliquer le fichier `/web/sites/sites.php.dist` en `/web/sites/sites.php`.
    - c'est ici qu'on relie l'URL du projet à son dossier (dossier theme)
- Dupliquer le fichier `/web/sites/{{ SITENAME }}/settings.php.dist` en `/web/sites/{{ SITENAME }}/settings.php`.
    - c'est ici que se trouve la conexion à la BDD du projet {{ SITENAME }}

### 3. Déployer tous les fichiers sur l'environnement de développement :

Configuration PhpStorm du déploiement automatique sur la VM :
- **Tools > Deployment > Configuration**
    - Onglet **"Connection"** :
        * SFTP host : **svd{{ VM }}pweb-stm.ressinfo.ad**
        * Port : **22**
        * Root path : **/root/DEV/**
        * User name : **root**
        * Auth type : **Key pair (OpenSSH or PuTTY)**
        * Private key file : **{{ LOCATION }}\drupal\docker\deployment\.sshlocal\id_rsa**
    - Onglet **"Mappings"** :
        * Local Path : {{ LOCATION }}**\drupal**
        * Deployment Path : **/drupal**
- **Tools > Deployment > Options...**
    - "Upload changed files automatically to the default server" : **Always**
    - Cocher "Upload external changes"

### 4. Installation des dépendances :

- via ligne de commande et composer : `composer install`
- option `-vvv` pour avoir une vision du proccess  

### 5. Lancer le projet :

- Lancer l'application via `docker-compose up -d`
- option `--build` pour recharger l'image Docker

### 6. Télécharger la BDD et les images :

- Récupérer les fichiers et la BDD :
    - passer le fichier `bin/synchfiles.sh` en **LF**
    - `docker-compose run --rm php bash bin/synchfiles.sh`
        - entrer le nom du site actuel {{ SITENAME }} - nom qui correspond au nommage du dossier theme
        - demander le nom de la BDD correspond au site {{ SITENAME }}, au pôle Web Cargo
        - demander l'user et le mdp de la BDD au pôle Web Cargo
- Appliquer le dump de la BDD :
    - passer le fichier `bin/synchbd.sh` en **LF**
    - `docker-compose exec db /bin/bash /var/www/html/bin/synchbd.sh`
        - entrer le nom de la base de données du site actuel {{ SITENAME }}

## Commandes Composer

- Installation d'une extension Drupal : `composer require 'NOM_DU_MODULE'`
    - **Attention : il ne faut pas passer par les .zip via l'interface mais bien par composer**
- Lister les modules qui ne sont plus à jours (entre la VM et le composer.lock) : `composer outdated`
- MAJ des dépendances avec les nouvelles versions disponibles : `composer update`
    - MAJ des modules externe Cargo uniquement : `composer update "cargo/*"`
- Installer les dépendances en fonction des versions présentes dans le composer.lock :  `composer install`

## URLs en lien avec le projet :

- Site : **http://web.{{ SITENAME}}.svd{{ VM }}pweb-stm.ressinfo.ad/**
- Admin du site : cela dépend du projet - à vérifier dans le fichier d'accès/urls sur le Drive
- PhpMyAdmin : **http://phpmyadmin.{{ SITENAME }}.svd{{ VM }}pweb-stm.ressinfo.ad**
    - root : root
- Mail : **http://web.mailhog.svd{{ VM }}pweb-stm.ressinfo.ad/**

## Divers

### Utiles :

- URL de MAJ BDD : `http://web.{{ SITENAME }}.svd{{ VM }}pweb-stm.ressinfo.ad/update.php`
- URL d'installation Drupal : `http://web.{{ SITENAME }}.svd{{ VM }}pweb-stm.ressinfo.ad/core/install.php`
- Rendre l'update de la BDD possible : dans settings.php du site {{ SITENAME }}, changer 
`$settings['update_free_access'] = FALSE;` en `$settings['update_free_access'] = TRUE;`
- Activer le debug Twig : dans **services.yml** du site {{ SITENAME }}, changer
`twig.config: debug: false` à `twig.config: debug: true`
- lancer une commande CLI : `php vendor/bin/drupal --uri=web.{{ SITENAME }}.svd{{ VM }}pweb-stm.ressinfo.ad`

### A savoir sur certains modules :

- le module newsletter, drupal_marketing_automation_core, synapse : sont gérés en interne 
(ainsi que la plupart des modules dans le dossier /modules/custom)

### Création d'un nouveau site Drupal dans la ferme :

[Voir la procédure ici](./NOUVEAU-DRUPAL.md)

### Dump de sa BDD en local :

- passer le fichier `bin/local-dump.sh` en **LF**
- lancer : `docker-compose exec db /bin/bash /var/www/html/bin/local-dump.sh`
    - Entrer le nom du site {{ SITENAME }}
    - Entrer l'action souhaitée (1, 2, etc)

### Déploiement (old) :

- `docker-compose run --rm bundle exec cap preproduction deploy` pour déployer en `preproduction`
    - on passe par Jenkins à présent

### Configure XDEBUG

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

### Gestion du cache Drupal :

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
* Pour plus de détails sur la gestion du cache : [https://www.drupal.org/node/2598914](https://www.drupal.org/node/2598914)

## Bugs déjà rencontrés :

### BDD : corruption après un arrêt forcé

En cas d'arrêt forcé de mysql et si ce dernier ne rédémarre pas correctement, ajouter cette commande dans le 
`docker-compose.yml` du site en question dans le service DB

```bash
command: mysqld --tc-heuristic-recover=ROLLBACK
```

### Erreur Drupal 

Lors de l'installation de modules, il arrive que Drupal se mette en erreur sans raison. Il faut aller
voir la table watchdog pour en savoir un peu plus sur l'erreur générée.

On peut aussi lancer un update.php.
