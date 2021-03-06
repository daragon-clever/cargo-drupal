# Module custom "Offres d'emploi"  
  
Ce module affiche les offres d'emploi de la société. On est ensuite redirigé vers le site SIRH Cargo
pour postuler à l'annonce sélectionnée.

Sites utilisant ce module :
- Groupe Cargo (Drupal - via ce module)
- Merch&Cie (Drupal - via ce module)
- Gers Equipement (Drupal - via ce module)
- Cogex (Drupal - via ce module)
- Centrakor (Magento - via l'API de ce module + le module Magento)
  
## Installation du module

1. Installez le module.
2. Vérifiez dans le fichier Helper/OffreEmploiHelperTrait.php qu'il y a bien le site en question
et qu'il est bien configuré.
3. Exécutez le cron via l'admin de Drupal.
4. Configurer l'url du site SIRH dans l'admin.
5. Récupérer les templates des sites ayant déjà le module d'installer.
Il faut également ajouter l'appel à la librairie datatable dans le theme du site.

S'il n'y a pas d'annonces qui remontent, vérifier qu'on a bien le fichier .json des offres dans le site
groupecargo (groupecargo/files/data/).

## Developpement  
  
Un cron qui passe tous les jours pour :  
* importer les nouvelles offres  
* désactiver les offres qui ne sont plus dans l'import  
Ce cron s'exécute en même temps que tous les autres crons du site  
  
## Intégration  
  
Pour surcharger le thème, il faut créer un nouveau fichier à la racine du dossier "templates" du site :  
* offres-emploi--list.html.twig : affiche tous les postes en attente de recrutement  
* offres-emploi--annonce.html.twig : affiche toutes les informations d'un seul poste  
  
## Le module  
  
### Les URL  
  
Les URL sont les suivantes :  
* /offres-emploi : visualiser toutes les offres d'emploi  
* /offres-emploi/`{{ref_du_poste}}` : afficher le contenu d'une offre en particulier  
  
### Les filtres  
  
Les filtres disponibles sont : (/offres-emploi?`{{filtre}}`=`{{value}}`)  
* filiale_societe  
* type_contrat  
* type_metier  
* lieu  
  
### Commandes  

* ``offre_emploi:import`` (pour importer toutes les offres d'emploi)
    * Pour l'exécuter sur VM : (se trouver dans le dossier multisites du site)
    ``docker-compose run --rm php vendor/bin/drupal --uri=web.gersequipement.svd1pweb-stm.ressinfo.ad offres_emploi:import``

### Api Rest

## Installation

Pour le bon déroulement de l'installation, il faut installer dans l'ordre:
 - Le module Consumer
 - Ximple_oauth
 - Offres_Emploi

## Configuration

Pour configurer l'api il faut : (uniquement sur le site groupecargo)
 - admcar/config/services/rest :
    * activer **Get List of job offers for CARGO**
    * mettre les params suivants: ['methodes => Get, 'Formats de requêtes acceptés' => json, 'Authentication providers' => oauth2 et cookie]
 - admcar/config/people/simple_oauth :
    * générer les certifs
    * chemins sur VM : **"../certificates/public.key"** et **"../certificates/private.key"**
 - admcar/people :
    * créer un utilisateur qui va consommer l'API
 - admcar/config/services/consumer :
    * ajouter un consumer (consommateur d'API)
    * lui donner accès à l'api dans les droits

##Call Api

Un système d'authentification a était mis en place pour protéger l'api. Donc, il faut faire un appel (/oauth/token) en Body avec : 
 - grant_type:password
 - client_id:(Identifiant universel unique (UUID) dans consumer)
 - client_secret:(le secret key dans consumer)
 - username:(Identifiant utilisateur)
 - password:(son mot de passe)
Ainsi, il faut envoyer tout ça avec un Header : Content-Type => application/x-www-form-urlencoded

Le token récupéré vous aidera à s'authentifier (via Bearer Token) à l'api. 

Endpoint de l'api sont : 
 - api/v1/offres-emploi/all?_format=json (pour récupirer toute la liste des offres actives) 
 - api/v1/offres-emploi/{CodeRecrutement} pour récupirer une offre
 
 
Un filtre existe pour filtrer seulement les offres d'une société en rajoutant un param name, exemple (?name=gersequipement)
Activer l'API **uniquement** sur le site groupe cargo. 