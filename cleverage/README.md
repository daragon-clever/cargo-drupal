# CleverAge

## À Propos

Ce document décris l'environnement de développement à l'usage des intervenants CleverAge

Il mutualise les sites dans un seul conteneur Docker à la différence de l'environnement de développement des équipes Cargo qui est basé sur des machines virtuelles dans lesquelles les sites sont déployés individuellement

Les dossiers `bin`, `config` et `multisites` sont réservés à l'environnement des équipes Cargo et ne concernent pas cet environnement

### Make

Cet environnement s'appuie sur des [commandes Make](./doc/Make.md) pour automatiser les opérations courantes avec Docker, vous pouvez afficher la liste des commandes disponibles en exécutant `make`

### Variables d'environnement

Le fichier `cleverage.env` contient les [variables d'environnement](./doc/Env.md) utilisées par Docker et Make, il est créé automatiquement lors de l'éxecution de n'importe quelle commande `make`

## Pré-requis
- Les programmes `make`, `bash`, `sed` et `awk`
- Docker ou Docker Desktop
- [Pré-requis MacOS](./doc/MacOS.md)

## Installation

L'installation est automatisée avec la [commande make install](./doc/Make.md#commandes-generales), vous pouvez par exemple installer les sites [sema-design](../web/sites/sema-design) et [genevieve-lethu](../web/sites/genevieve-lethu) avec la commande

```shell
make install sites="sema-design genevieve-lethu"
```

Ou bien un installer un seul d'entre eux

```shell
make install sites=sema-design
```

Ou encore installer juste les dépendances composer avec [make install](./doc/Make.md#commandes-generales) puis installer les sites un par un avec la commande [make dr/install](./doc/Make.md#commandes-drush)

### Résolution DNS

>Note : Le nom de domaine de l'environnement est défini par la variable [TRAEFIK_DOMAIN](./doc/Env.md) qui est par défaut `cargo.local`, veillez à adapter les instructions ci-dessous si vous avez modifié sa valeur.

Pour accéder aux services par leur noms de domaines il vous faut ajouter les lignes suivantes dans votre fichier `/etc/hosts`

```shell
127.0.0.1 cargo.local traefik.cargo.local mail.cargo.local phpmyadmin.cargo.local
```

>**Important** : complétez la liste avec le nom de chaque site que vous installez ( par exemple : `genevieve-lethu.cargo.local`  si vous avez installé le site `genevieve-lethu` )

### URLs des services

| URLs    | Service |
|--       |--       |
| https://traefik.cargo.local/ | Reverse proxy Traefik |
| https://mail.cargo.local/<br>https://mailhog.cargo.local/ | Mailhog |
| https://php.cargo.local/<br>https://phpmyadmin.cargo.local/ | PhpMyAdmin |
| https://cargo.local/<br>https://[site].cargo.local/ | Nginx |

### Certificat TLS

Vous pouvez exporter le certificat auto-signé généré depuis le conteneur traefik avec la commande [make tls.crt](./doc/Make.md#commandes-du-conteneur-traefik) et l'ajouter aux autorités de certification de confiance de votre navigateur web afin de naviguer en https sans avertissements sur la validité du certificat
