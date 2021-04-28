# Module custom "Offres partenaires"  
  
Ce module permet d'afficher les offres d'emploi partenaires / offres vacantes et d'y postuler, grâce à l'API de 
ScopTalent.

## Installation

1. Activer le module
2. Lancer le cron drupal
3. Configurer le webform. Penser à ajouter le handler de ce module, et ne pas oublier les 2 champs cachés avec l'id de 
l'offre et le nom du poste (utile pour l'envoi de mail).

## Fonctionnement

* Stockage des offres en base pour soulager l'appel API.
* Cron qui passe pendant le cron drupal pour mettre à jour les offres de Scoptalent sur notre BDD.

## Configuration du module

* Sur l'admin de Drupal : Configuration > Système > Cargo - Offres prestataires
    * Clé API Scoptalent
    * ID de l'offre spontanée

## A savoir

* Il existe un id pour les offres spontanées (43723 actuellement) afin de bien les visualiser sur l'interface de 
Scoptalent.
* Fichiers configuration taxonomy (webform options) : **config/install/** tous les fichiers

## ScopTalent

### API

* URL : https://api.scoptalent.com/
* Documentation : https://api.scoptalent.com/documentation/fr/
* Clés :
    * Pour test : **7de8991be6044c7abaa3b4f78a8b32c2**
    * Pour Merch : **99803e9a45b0430ba683c75fa9827ae4**


