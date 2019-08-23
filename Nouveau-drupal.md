# Création d'un nouveau site Drupal dans la ferme

1.  Dans le dossier multisites, créez un nouveau dossier en reprenant celui d'une site déjà existant.
    
    Dans ce dossier, il y a 2 fichier : 
    * .env
    * docker-compose.yml

    Dans le fichier **.env**, modifiez le nom du projet afin renseignez le nom de votre nouveau site.
    
2.  Se rendre dans le dossier **/web/sites** et ouvrir le fichier **sites.php**.
    
    Dupliquez une ligne et modifier le clé et la valeur (clé => valeur). 
    
    Exemple : web.monsite.[...].ad => 'monsite'
    
    Dans la clé, le nom du site correspond au nom renseigné dans le fichier .env.
    
    Dans la valeur, le nom du site correspond au nom du dossier.
    
3.  Se rendre dans **/web/sites** et créer un dossier -vide- avec le même nom que votre dossier créé dans **/multisites**.
    
4.  Lancez la commande : **docker-compose up -d**
    
5.  Se rendre sur l'URL indiqué dans le fichier sites.php : web.monsite.[...].ad

    Cela propose une installation de Drupal. Vous pouvez donc commencer à installer et configurer votre installation.
    
    Sur la page pour configurer la base de données : cliquez sur **options avancées**.
    
    Dans ces options avancées, modifier le nom de l'hôte. Remplacer "localhost" par "db".
    
    Le nom d'utilisateur et le mot de passe sont root / root.
    
    A la fin de l'installation, il faut créer un compte. Renseignez en nom utilisateur "PoleWeb" et utiliser un générateur de mot de passe en ligne.
    
    Une fois le compte créé, le renseigné dans [le fichier drive](https://docs.google.com/spreadsheets/d/1CDImdpjfhHTQ7QIl8nPDTH2E4YMK95f3pVr4VcF04eo/edit?usp=drive_web&ouid=115862130752555752839)

6.  Une fois l'installation fini, installez les modules communs à tous les sites (adminimal, ...).