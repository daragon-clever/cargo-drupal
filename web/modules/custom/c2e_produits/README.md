# Module custom "C2E Produits"

Ce module affiche les produits de **S0** (semaine actuelle) et **S1** (semaine prochaine) grâce à des fichiers 
générés dans le dossier **files/dataimages** et **files/datacsv**.
Il y a également un **flux rss** de présent pour générer un flux pour S0 et S1 (principalement pour Actito).

## Commande

2 commandes dans ce module :
- c2e_produits:check : contrôle si tous les produits sont présents, ainsi que les images, pour
S0 et S1
- c2e_produits:generate-flux-rss : créer le flux RSS, utilisé dans Actito

## Cron

Un cron exécute ces 2 commandes à 7h15

## ++

Exécuter sur sa VM : 
`docker-compose run --rm php vendor/bin/drupal --uri=web.cestdeuxeuros.svdXpweb-stm.ressinfo.ad`
avec la commande qui suite.  Pensez à remplacer le X par le numéro de votre VM.