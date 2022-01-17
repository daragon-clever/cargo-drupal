# Module Newsletter

- création d'un table **newsletter_subscriber**
- création d'un event **newsletter_save**
- création d'un formulaire (via un Block) qui vient alimenter la table

Module qui s'adapte à chaques sociétés configurés.

## Mise en place pour une société

1. Compléter le fichier **Config/NewsletterInitConfig** avec la nouvelle société
    - **Aide :** Pour trouver le nom du site, se rendre sur l'admin : **Configuration/Système/Paramètres de base du site**
          - *Exemple n°1 :* site C'est Deux Euros, nom du site "C'est deux euros". Je met dans le switch "c'estdeuxeuros".
          - *Exemple n°2 :* site Sitram, nom du site "Blog.SITRAM.fr". Je met dans le switch "blog.sitram.fr".
2. Dans chaque switch du module, ajouter la société :
    - **Form/FormController**
    - **SchemaTable/SchemaTableController**
    - **Update/UpdateController**
3. Champs supplémentaire sur le formulaire : 
    - ajouter des champs supplémentaires dans la BDD : créer un fichier **SchemaTable** spécifique
    - ajouter les champs supplémentaires dans le formulaire : créer un fichier **Form** spécifique
    - ajouter les champs lors de l'ajout à la BDD : créer un fichier **Profile** spécifique

## Modification d'un formulaire newsletter

1. Faire une mise à jour du module dans le fichier **newsletter.module**
2. Ajouter la mise à jour dans le dossier **Update**. Dans la class de **Base** si cela concerne tout le monde, sinon dans
un class **spécifique**.

## Plusieurs abonnements

Si on a plusieurs types d'abonnement, il faut ajouter une colonne supplémentaire uniquement pour la filiale concernée 
: voir pour exemple Yliades 

## MAJ du module

Pour mettre à jour le module, il faut exécuter l'url /update.php. Cela va lancer les update présent dans
le fichier newsletter.module

## Sites utilisant actuellement ce module :

* C'est Deux Euros
* Comptoir De Famille
* Côté Table
* Merch&Cie
* Sitram
* Yliades
* Sema Design
