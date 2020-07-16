
# Module custom "Offres d'emploi"  
  
Ce module affiche les offres d'emploi de :  
* toutes les sociétés sur le site Cargo  
* de la société du site, pour un site précis (ferme Drupal)  
  
## Installation  
  
1. Installez le module.  
2. Créez un Webform avec pour ID 'postuler_annonce'.  
3. Pour former la structure du formulaire, commencer par copiez/collez les 2 champs hidden (offre et nom_offre) du YAML d'un site ayant le module actif.  
4. Dans l'onglet Paramètres, cliquez sur Courriels / Gestionnaires (Handlers).  
5. Ajouter le handler "OffresEmploiHandler" à ce formulaire. Aucune config à réaliser.  
  
## Developpement  
  
Un cron qui passe tous les jours pour :  
* importer les nouvelles offres  
* désactiver les offres qui ne sont plus dans l'import  
Ce cron s'exécute en même temps que tous les autres crons du site  
  
## Intégration  
  
Pour surcharger le thème, il faut créer un nouveau fichier à la racine du dossier "templates" du site :  
* offres-emploi--list.html.twig : affiche tous les postes en attente de recrutement  
* offres-emploi--annonce.html.twig : affiche toutes les informations d'un seul poste  
* offres-emploi--form-postuler.html.twig : affiche le formulaire pour postuler à l'offre  
  
## Le module  
  
### Les URL  
  
Les URL sont les suivantes :  
* /offres-emploi : visualiser toutes les offres d'emploi  
* /offres-emploi/`{{ref_du_poste}}` : afficher le contenu d'une offre en particulier  
* /offres-emploi/postuler/`{{ref_du_poste}}` : afficher un formulaire pour postuler à l'annonce  
  
### Les filtres  
  
Les filtres disponibles sont : (/offres-emploi?`{{filtre}}`=`{{value}}`)  
* filiale_societe  
* type_contrat  
* type_metier  
* lieu  
  
### Commandes  
* offre_emploi:import (pour importer toutes les offres d'emploi)
* docker-compose run --rm php vendor/bin/drupal --uri=web.gersequipement.svd1pweb-stm.ressinfo.ad offres_emploi:import


### Api Rest
Pour configurer l'api il faut :
 - Créer un compte pour l'authentification et ne lui donner que l’accès Get pour l'api;
 - Vérifier si ces modules sont bien installés et activer : (HAL, Http Basic Authentification, REST UI, RESTful Web Services, Serialization)
 - Dans la configuration de REST resources (admger/config/services/rest) => Activer la ressource et mettre les params suivants: ['methodes => Get, 'Formats de requêtes acceptés' => json, 'Authentication providers' => basic_auth et cookie]

l'Api est accessible depuis : api/v1/offres-emploi/?_format=json
Un filtre existe pour filtrer seulement les offres d'une societe en rajoutant un param name, exemple (?name=gersequipement)
Ne pas activer l'api que dans le site groupe cargo. 