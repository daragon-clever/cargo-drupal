# Module Newsletter

## Mise en place pour une société

Le module peut s'adapter à toutes les filiales du groupe. 

Pour cela :
* Créer un fichier dans le dossier **Controller/Company** puis un fichier dans le dossier **Form/Company** 
(prendre exemple sur ceux déjà existant)
* Ajouter le nom du site dans tous les switch (minuscule et sans espace).
Pour trouver le nom du site, se rendre sur l'admin : **Configuration/Système/Paramètres de base du site**
     * *Exemple n°1 :* sur le site de C'est Deux Euros, le nom du site est "C'est deux euros". Je met dans le switch "c'estdeuxeuros".
     * *Exemple n°2 :* Sur le site de Sitram, le nom du site est "Blog.SITRAM.fr". Je met dans le switch "blog.sitram.fr".

    Les 2 switch se trouvent ici :
    * newsletter/src/Controller/NewsletterController.php
* A ajouter dans setting.php du site (**Attention :** fichier non versionné) :
`$config['system.newsletter'] = [
     'allowTest' => 'true' // false si sur env prod 
 ];`

## Table créée

Ce module va créer 1 table sur la base de données du site :
* newsletter_subscriber : une ligne = un abonné = des infos sur l'abonné
    - si on a plusieurs types d'abonnement, il faut ajouter une colonne supplémentaire pour
    la filiale concerné (voir pour exemple : Yliades et C2E)

## Fonctionnement

Lors de l'ajout d'une personne sur la table, elle s'importe automatiquement sur Actito en passant par l'API 
en interne (WEB_Api_Contact_Actito).

## Sites utilisant actuellement ce module :

* Blog Sitram
* C'est Deux Euros
* Côté Table
* Comptoir De Famille
* Merch&Cie
* Sitram
* Yliades
