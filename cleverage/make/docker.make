COMPOSE				:= docker-compose --env-file cleverage.env

# MacOS
ifeq ($(DOCKER_HOST_PLATFORM),Darwin)
COMPOSE				:= mutagen-compose
endif

dc/build:: ## Construis une ou plusieurs images
	$(COMPOSE) build $(args) $(service)

dc/config:: ## Affiche la configuration docker-compose
	$(COMPOSE) config $(args)

dc/services:: ## Affiche les noms des services
	$(MAKE) dc/config args=--services

dc/up:: # Démarre les conteneurs en premier plan
	$(COMPOSE) up --remove-orphans $(args)

dc/up-d:: # Démarre les conteneurs en arrière plan
	$(MAKE) dc/up args=--detach

dc/ps:: # Affiche les conteneurs stoppés et en cours d'exécution
	$(COMPOSE) ps --all

dc/logs:: # Affiche les logs d'un où plusieurs conteneurs
	args="$(args)";
	[ ! -z "$(tail)" ] && args="$${args} --tail $(tail)"
	[ -z "$(nofollow)" ] && args="$${args} --follow"
	$(COMPOSE) logs $${args} $(service)

dc/exec:: ## Exécute une commande dans un conteneur en cours d'exécution
	[[ -z "$(service)" || -z "$(cmd)" ]] && { cat <<-'EOF'
		Usage :
		    make $(@) service cmd [options]
		Arguments :
		    - service   Le nom du service
		    - cmd       La commande à exécuter
		Options:
		    - user      L'utilisateur du conteneur
		    - workdir   Le répertoire courant du conteneur
			- args      Arguments supplémentaires
		Exemples:
		    make $(@) service=php user=www-data workdir=/var/www/html cmd=bash
		    make $(@) service=db user=mysql cmd='bash -c "-h 127.0.0.1 -u root -p"'
		    make $(@) service=mail cmd=bash
		EOF
		exit 0
	}
	args="$(args)"
	[ ! -z "$(user)" ] && args="$${args} --user $(user)"
	[ ! -z "$(workdir)" ] && args="$${args} --workdir $(workdir)"
	$(COMPOSE) exec $${args} $(service) $(cmd)

dc/stop:: # Stoppe les conteneurs
	$(COMPOSE) stop

dc/down:: ## Détruis les conteneurs mais conserve les volumes
	$(COMPOSE) down $(args)

dc/nuke:: ## Détruis les conteneurs, volumes et images locales
	$(MAKE) dc/down args='--volumes --rmi local'
