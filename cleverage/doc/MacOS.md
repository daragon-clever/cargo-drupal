# [CleverAge](../README.md) - MacOS

## À Propos

La stack Docker sur MacOS s'appuie sur [Mutagen Compose] pour fournir de meilleures performances aux montages de systèmes de fichiers avec Docker Desktop

Ce choix implique d'utiliser la commande `mutagen-compose` au lieu de `docker-compose` lors de vos intéraction avec la stack Docker en dehors des [commandes Make](./Make.md) disponibles

## Configuration

1. Assurez-vous que votre système et Docker Desktop sont à jour

2. Désactivez l'option `Use gRPC FUSE for file sharing` depuis l'onglet [General de Docker Desktop](https://docs.docker.com/desktop/mac/#general)

3. Allouez au moins `2 CPUs` et `6.00 GB` depuis l'onglet [Ressources de Docker Desktop](https://docs.docker.com/desktop/mac/#resources)

## Installation des dépendances

1. Installez [HomeBrew](https://github.com/Homebrew/install#install-homebrew-on-macos-or-linux) si il n'est pas déjà présent

```shell
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/master/install.sh)"
```

2. Installez les dernières versions de `make`, `bash`, `sed` et [Mutagen Compose]

```shell
brew install make bash gnu-sed mutagen-io/mutagen/mutagen-compose-beta
```

3. Créez ou mettez à jour votre fichier `~/.zshrc` comme mentionné lors de l'installation en y ajoutant les lignes suivantes

```shell
[ -d /usr/local/opt/make/libexec/gnubin ] && PATH="/usr/local/opt/make/libexec/gnubin:$PATH"
[ -d /usr/local/opt/gnu-sed/libexec/gnubin ] && PATH="/usr/local/opt/gnu-sed/libexec/gnubin:$PATH"
mutagen daemon start 1> /dev/null
```

4. Rechargez votre fichier `~/.zshrc` pour tenir compte des changements dans votre terminal actuel

```shell
source ~/.zshrc
```

[Mutagen Compose]: https://mutagen.io/documentation/orchestration/compose
