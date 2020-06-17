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

    Les switch se trouvent ici :
    * newsletter/src/Plugin/Block/InscriptionBlock.php
    * newsletter/src/Controller/NewsletterController.php
    * newsletter/newsletter.module
* A ajouter dans setting.php du site (**Attention :** fichier non versionné) :
`$config['system.newsletter'] = [
     'allowTest' => 'true' // false si sur env prod 
 ];`

## Tables créées

Ce module va créer 2 tables sur la base de données du site :
* newsletter_subscriber : une ligne = un abonné = des infos sur l'abonné
* newsletter_subscribption : une ligne = un ou plusieurs abonnement = un abonné.
Cette table n'est utilisée/remplie que lorsque le site propose différents abonnements/segments (c2e et yliades, par exemple)

## Fonctionnement

Lors de l'ajout d'une personne sur la/les table(s), elle s'importe automatiquement sur Actito en passant par l'API 
en interne (API_Contact_Actito).

## Sites utilisant actuellement ce module :

* Blog Sitram
* C'est Deux Euros
* Comptoir De Famille
* Yliades

## Mise en place du module sur un nouveau site :
