#NOUVEAU DRUPAL
Création d'un nouveau site Drupal dans la ferme

**Pré-requis :**
- Remplacer {{ SITENAME }} par le nom du nouveau site
- Remplacer {{ PROJECT_NAME }} par le nom du dossier du nouveau site
- Remplacer {{ TRIGRAMME }} par au moins 3 lettres du site actuel

## Installation

Pour l'installation d'un nouveau site dans la ferme, on va se baser sur un site précédemment créé (peu importe lequel).

### Dossiers et fichiers de configuration

1. Dans le dossier `/multisites`, créer un dossier `{{ PROJECT_NAME }}` en dupliquant le dossier d'un site déjà existant.
    - Dans ce dossier, il y 3 fichiers :
        - **.env** : `COMPOSE_PROJECT_NAME={{ SITENAME }}`
            - on n'est pas obligé de lui donné le même nom que 
        - **.rvmc** : on touche pas
        - **docker-compose.yml**
            - modifier les aliases des différents containers (ils doivent être uniques pour ne pas rentrer en conflit avec les autres projets) :
                - `web_{{ TRIGRAMME }}`
                - `php_{{ TRIGRAMME }}`
                - `db_{{ TRIGRAMME }}`
                - `phpmyadmin_{{ TRIGRAMME }}`

2. Dans le dossier `/web/sites` :
    - Ouvrir le fichier `sites.php` et dupliquer une ligne, puis modifier la clé et la valeur
        - Exemple : `web.{{ SITENAME }}.[...].ad => '{{ PROJECT_NAME }}'`
    - Créer un dossier `{{ PROJECT_NAME }}`
    - Dans ce dossier, ajouter le fichier `settings.php` en le dupliquant d'un autre site
        - Modifier les informations de connexion à la BDD (en bas du fichier) : 
            - database : `{{ SITENAME }}`
            - host : `db_{{ TRIGRAMME }}`

3. Lancer le projet via `docker-compose up -d`

4. Se rendre à l'URL du projet, indiquée précédement dans **sites.php** : 
http://web.{{ SITENAME }}.[...].ad/
    - Ajouter le paramètre pour installer le projet : **/core/install.php**
    - Choisir le mode **standard**
    - A la fin du proccess d'installation, il faut créer un compte administrateur : 
        - user : Poleweb
        - mdp : à définir (utiliser un générateur de mot de passe en ligne)
        - Une fois le compte créé, le renseigné dans [le fichier drive](https://docs.google.com/spreadsheets/d/1CDImdpjfhHTQ7QIl8nPDTH2E4YMK95f3pVr4VcF04eo/edit?usp=drive_web&ouid=115862130752555752839)

5. Une fois le site up et Drupal installé, se rendre sur l'URL du projet et installer les modules utilisées couramment 
sur les autres sites (Adminimal, Google, ...)

## Déploiement

### Dossiers et fichiers à pousser

- fichier `config/deploy.rb` : ajouter le nom du nouveau site `{{ PROJECT_NAME }}` aux mêmes endroits que les autres sites
    - permet de gérer les dossiers en shared
- créer un fichier `settings.php.dist` en plus du `settings.php` (le dupliquer)
- penser à :
    - désactiver l'update depuis la preprod et la prod sur le fichier `settings.php`
    - désactiver le debug twig sur le fichier `services.yml`

### Serveur

- voir avec Sébastien pour configurer le déploiement côté serveur, la configuration de la preprod, la configuration de la prod
