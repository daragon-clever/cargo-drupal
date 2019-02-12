# Module custom "Offres d'emploi"

Ce module affiche les offres d'emploi de :
* toutes les sociétés pour le site Cargo
* de la société du site, pour un site précis (ferme Drupal)

## Developpement

Il y a un cron qui passe tous les jours pour :
* importer les nouvelles offres
* désactiver les offres qui ne sont plus dans l'import

## Intégration

Pour surcharger le thème, il faut créer un nouveau fichier à la racine du dossier "templates" du site :
* annonce.html.twig : affiche toutes les informations d'un seul poste
* les-offres-emploi.html.twig : affiche tous les postes en attente de recrutement

## Le module

### Les URL

Les URL sont les suivantes :
* /offres-emploi : visualiser toutes les offres d'emploi
* /offres-emploi/`[[ref_du_poste]]` : afficher le contenu d'une offre en particulier
* /offres-emploi/postuler/`[[ref_du_poste]]` : afficher un formulaire pour postuler à l'annonce

### Les filtres

Les filtres disponibles sont : (/offres-emploi?`[[filtre]]`=`[[value]]`)
* filiale_societe
* type_contrat
* type_metier
* lieu
