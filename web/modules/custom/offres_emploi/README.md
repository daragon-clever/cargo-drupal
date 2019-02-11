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

