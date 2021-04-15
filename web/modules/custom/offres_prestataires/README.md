# Module custom "Offres partenaires"  
  
Ce module permet d'afficher les offres d'emploi partenaires / offres vacantes et d'y postuler, grâce à l'API de ScopTalent.

## Installation

1. Activer le module
2. Lancer le cron drupal
3. Configurer le webform. Penser à ajouter le handler de ce module.

## Fonctionnement

Stockage des offres en base pour soulager l'appel API.
Cron qui passe pendant le cron drupal pour mettre à jour les offres de Scoptalent sur notre BDD.

## ScopTalent

### API

* URL : https://api.scoptalent.com/
* Documentation : https://api.scoptalent.com/documentation/fr/

## Config

* ApiKey : src/Helper/Request.php (à rendre administrable)
* Webform options : config/install/ tous les fichiers
