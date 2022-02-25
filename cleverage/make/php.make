php/exec:: ## Exécute une commande dans le conteneur php
	user="$(user)"; [ -z "$${user}" ] && user=www-data
	$(MAKE) dc/exec service=php user=$${user}

php/shell:: # Ouvre un terminal dans le conteneur php
	$(MAKE) php/exec cmd=bash

php/info:: ## Affiche les informations sur la configuration php
	$(MAKE) php/exec cmd="php -i"

composer/%:: name=$*
composer/%:: # Exécute une commande composer dans le conteneur php
	$(MAKE) php/exec args="$(dockerargs)" cmd="composer $(name) $(args)"
