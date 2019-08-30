# Module Newsletter pour toutes les filiales de Cargo

Ce module ajoute les personnes sur la base de données du site. Il créé 2 table :
* newsletter_subscriber : regroupe les infos des personnes enregistrés
* newsletter_subscription : regroupe les infos de souscriptions dans le cas où un site propose différents abonnements
De plus, il envoie les personnes sur Actito lors de leur souscription.

## Sites utilisant actuellement ce module :

* Blog Sitram
* C'est Deux Euros
* Comptoir De Famille
* Yliades

## Mise en place du module sur un nouveau site :
* Créer un fichier dans le dossier **Controller/Company** puis **Form/Company** (prendre exemple sur ceux déjà existant)
* Ajouter le nom du site dans tous les switch (minuscule et sans espace). Pour trouver le nom du site, se rendre sur l'admin : **Configuration/Système/Paramètres de base du site**

     *Exemple n°1 :* sur le site de C'est Deux Euros, le nom du site est "C'est deux euros". Je met dans le switch "c'estdeuxeuros".

     *Exemple n°2 :* Sur le site de Sitram, le nom du site est "Blog.SITRAM.fr". Je met dans le switch "blog.sitram.fr".

* A ajouter dans setting.php du site (**Attention :** fichier non versionné) :
`$config['system.newsletter'] = [
     'allowTest' => 'true' // false si sur env prod 
 ];`