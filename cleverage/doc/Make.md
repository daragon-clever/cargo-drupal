# [CleverAge](../README.md) - Commandes Make

La liste ci-dessous n'est pas exhaustive et peut changer au fil du temps, veuillez exécuter la commande `make help/all` pour afficher toutes les commandes disponibles

### Commandes générales

_Source : [Makefile](../Makefile)_

| Nom  | Description |
|-     |-            |
| `install`   | Installe la stack Docker locale en exécutant la procédure suivante<br><ol><li>Démarrage des conteneurs avec `make dc/up-d`</li><li>Installation des dépendances composer avec `make composer/install`</li><li>Création du fichier [web/sites/sites.php](../../web/sites/sites.php)</li><li>Installation des sites avec `make dr/install` si le paramètre `sites` est défini</li></ol>Vous pouvez spécifier les sites à installer avec le paramètre `sites`, par exemple `make install sites="sema-design genevieve-lethu"` installera les sites [sema-design](../../web/sites/sema-design) et [genevieve-lethu](../../web/sites/genevieve-lethu) |
| `uninstall` | Désinstalle la stack Docker locale en exécutant `make dc/nuke` |
| `clean` | Supprime les fichier ignorés par git :warning: |

### Commandes d'aide

_Source : [help.make](../make/help.make)_

| Nom  | Description |
|-     |-            |
| `help`        | Affiche les principales commandes disponibles, affichée par défaut avec la commande `make` |
| `help/all`    | Affiche toutes les commandes disponibles |
| `help/[name]` | Affiche les commandes d'un espace de noms selon le paramètre `name`, par exemple, exécutez `make help/docker` pour afficher les commandes Docker |

### Commandes Docker

_Source : [docker.make](../make/docker.make)_

| Nom  | Description |
|-     |-            |
| `dc/build`    | Construis une ou plusieurs images Docker |
| `dc/config`   | Affiche la configuration docker-compose |
| `dc/services` | Affiche les noms des services |
| `dc/up`       | Démarre les conteneurs en premier plan |
| `dc/up-d`     | Démarre les conteneurs en arrière plan |
| `dc/ps`       | Affiche les conteneurs stoppés et en cours d'exécution |
| `dc/logs`     | Affiche les logs d'un où plusieurs conteneurs |
| `dc/exec`     | Exécute une commande dans un conteneur en cours d'exécution |
| `dc/stop`     | Stoppe les conteneurs |
| `dc/down`     | Détruis les conteneurs mais conserve les volumes |
| `dc/nuke`     | Détruis les conteneurs, volumes et images locales |

### Commandes du conteneur mariadb

_Source : [db.make](../make/db.make)_

| Nom  | Description |
|-     |-            |
| `db/exec`    | Exécute une commande dans le conteneur mariadb |
| `db/shell`   | Ouvre un terminal dans le conteneur mariadb |
| `db/mysql`   | Ouvre un terminal Mysql dans le conteneur mariadb |
| `db/query`   | Exécute une instruction Mysql dans le conteneur mariadb |
| `db/list`    | Liste les bases de données |
| `db/create`  | Créé une nouvelle base de données |
| `db/drop`    | Supprime une base de données |

### Commandes du conteneur php

_Source : [php.make](../make/php.make)_

| Nom  | Description |
|-     |-            |
| `php/exec`        | Exécute une commande dans le conteneur php |
| `php/shell`       | Ouvre un terminal dans le conteneur php |
| `php/info`        | Affiche les informations sur la configuration php |
| `composer/[name]` | Exécute une commande composer dans le conteneur php |

### Commandes Drush

_Source : [drush.make](../make/drush.make)_

| Nom  | Description |
|-     |-            |
| `dr/[name]`  | Exécute une commande Drush selon le paramètre `name` dans le conteneur php<br>Le paramètre `site` permets de spécifier le répertoire courant depuis lequel la commande Drush sera exéctuée<br>Par exemple `make dr/core-status site=sema-design` exécute la commande `drush core-status` depuis le répertoire `/var/www/html/web/sites/sema-design`<br><br>Les actions suivantes sont exécutées lorsque le paramètre `site` est défini :<ol><li>Vérification de l'existence du répertoire `web/sites/${site}`</li><li>Création du fichier `web/sites/${site}/settings.php` à partir du fichier `web/sites/${site}/settings.php.dist`</li><li>Création du fichier `web/sites/${site}/settings.local.php` à partir du fichier `sites/example.settings.local.php`</li><li>Ajout du site dans le fichier `web/sites/sites.php`</li></ol> |
| `dr/install` | Installe un où plusieurs sites Drupal avec Drush selon le paramètre `sites` en exécutant la procédure suivante<br><ol><li>Résouds le nom de la base de données à créer avec la commande `make dr/core-status`</li><li>Créé la base de données avec la commande `make db/create`</li><li>Installe le site avec la commande `make dr/site-install`</li></ol> |

### Commandes du conteneur traefik

_Source : [tls.make](../make/tls.make)_

| Nom  | Description |
|-     |-            |
| `tls.crt`      | Exporte le certificat auto-signé à importer dans votre navigateur |
| `tls/certinfo` | Affiche les informations du certificat |
