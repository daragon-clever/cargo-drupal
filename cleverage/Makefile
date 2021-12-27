MAKE			+= --no-print-directory
SHELL			:= /usr/bin/env
.SHELLFLAGS		:= bash -Eeuo pipefail
ifdef DEBUG
.SHELLFLAGS		+= -x
endif
.SHELLFLAGS		+= -c
ifndef VERBOSE
.SILENT:
endif
.DEFAULT_GOAL	:= help
.ONESHELL:

# Créé le fichier .env s'il n'existe pas
$(shell [ -f .env ] || { \
	cp cleverage/.env.dist .env; \
	PLATFORM="$$( uname -s )"; \
	sed -Ei 's#^(DOCKER_HOST_PLATFORM=).*#\1'"$${PLATFORM}"'#g; \
		s#^(DOCKER_HOST_UID=).*#\1'"$$( id -u )"'#g; \
		s#^(DOCKER_HOST_GID=).*#\1'"$$( id -G | awk '{ print $$NF }' )"'#g' .env; \
	[ "$$PLATFORM" == "Darwin" ] && \
		sed -Ei 's#^(COMPOSE_FILE=.*)#\1:cleverage-compose.mac.yml#g' .env; \
	[ ! -z "$(domain)" ] && sed -Ei 's#^(TRAEFIK_DOMAIN=).*#\1$(domain)#g' .env; \
})

# Importe les variables d'environnement dans le contexte du Makefile
include .env

# Exporte les variables d'environnement dans le contexte des commandes Make
export $(foreach e, $(shell grep -Eio '^([^\#\=]+)' .env), $(e))

# Inclus les autres fichiers make
include cleverage/make/*.make

# Déclare les commandes make qui ne produisent pas de fichiers
.PHONY: $(shell grep -Eho '^([^ \#\.A-Z]+):( |$$)' $(MAKEFILE_LIST) | sed 's/:.*/ /g')

install: # Installe la stack Docker locale
	$(MAKE) dc/up-d
	$(MAKE) composer/install
	if [ ! -f web/sites/sites.php ]; then
		cat <<-'EOF' > web/sites/sites.php
		<?php
		$$sites = [
		];
		EOF
	fi
	if [ ! -z "$(sites)" ]; then
		while ! $(MAKE) db/query sql="SELECT TRUE;" &>/dev/null; do
			echo "En attente que le serveur mysql soit prêt..."; sleep 3
		done
		$(MAKE) dr/install
	fi

uninstall: dc/nuke # Désinstalle la stack Docker locale

clean: ## Supprimes les fichiers ignorés par Git
	args=; [ ! -z "$(dry_run)" ] && args=n
	git clean -ffdX$${args}
