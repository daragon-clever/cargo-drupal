Ajoutez ces lignes dans le fichier settings.php du site utilisant le module : (**/sites/nom_du_site/settings.php**)

```
$config['system.qrcodeadm'] = [
    'soc' => 'TBC', //FCA, CGXEPI, ...
    'prod' => false, //true for prod environment
    'mailTesterreur' => 'poleweb@cargo-services.fr',
];
```

**Attention :** fichier non versionné. 
* Ajoutez ces lignes sur le fichier en preprod et prod.
* Modifiez la clé "prod" à true, **uniquement** en prod.
* Modifiez la clé "soc" avec la clé de la constante **QRCODEADM** correspondant aux params du site, dans **/modules/custom/recherche_pdf/sr/Config/ConfigFile.php** (TBC pour Turbocar, FCA pour Facom, ...)