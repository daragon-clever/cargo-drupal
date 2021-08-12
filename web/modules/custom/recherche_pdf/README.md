# Module recherche_pdf Drupal - Cargo

## Ajouter un formulaire sur une page

2 solutions pour ajouter un formulaire de recherche PDF sur un site Drupal :
- Créer un type de contenu avec un champ de type block
- Ajouter le block dans la mise en page des blocs

Il y a de la configuration à faire sur le block, comme par exemple l'entité à laquelle on souhaite accéder sur l'outil
admin.url-qrcodes, l'affichage du deuxième champ sur le formulaire, etc.

## Fonctionnalités

Permet de :
- télécharger un ou plusieurs fichiers PDF en lien avec une référence (et des fois un numéro de lot) à la 
soumission d'un formulaire
- afficher tous les fichiers PDF en lien avec une référence (et des fois un numéro de lot) à la soumission 
d'un formulaire

## A savoir

- Si le module est déjà installé sur un site et que des traductions sont ajoutées/mises à jour dans le fichier recherche_pdf.po,
il va falloir se rendre ici **admin/config/regional/translate/import** pour réimporter le fichier.
