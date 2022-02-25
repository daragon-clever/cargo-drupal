MAKE			:= make --no-print-directory
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
.EXPORT_ALL_VARIABLES:

# Créé le fichier cleverage.env s'il n'existe pas
ifeq ($(wildcard cleverage.env),)
$(shell \
	cp cleverage/.env.dist cleverage.env; \
	PLATFORM="$$( uname -s )"; \
	sed -Ei 's#^(DOCKER_HOST_PLATFORM=).*#\1'"$${PLATFORM}"'#g; \
		s#^(DOCKER_HOST_UID=).*#\1'"$$( id -u )"'#g; \
		s#^(DOCKER_HOST_GID=).*#\1'"$$( id -G | awk '{ print $$NF }' )"'#g' cleverage.env; \
	[ "$$PLATFORM" == "Darwin" ] && \
		sed -Ei 's#^(COMPOSE_FILE=.*)#\1:cleverage-compose.mac.yml#g' cleverage.env; \
	[ ! -z "$(domain)" ] && sed -Ei 's#^(TRAEFIK_DOMAIN=).*#\1$(domain)#g' cleverage.env; \
)
endif

# Importe les variables d'environnement dans le contexte du Makefile
include cleverage.env

# Inclus les autres fichiers make
include cleverage/make/*.make

# créé le fichier web/sites/sites.php
web/sites/sites.php:
	cat <<-'EOF' > $@
	<?php
	$$sites = [
	];
	EOF

install:: web/sites/sites.php # Installe la stack Docker locale
	$(MAKE) dc/up-d
	$(MAKE) composer/install
	if [ ! -z "$(sites)" ]; then
		while ! $(MAKE) --silent db/query sql="SELECT TRUE;" &>/dev/null; do
			echo "En attente que le serveur mysql soit prêt..."; sleep 3
		done
		$(MAKE) dr/install
	fi

uninstall:: dc/nuke # Désinstalle la stack Docker locale

clean:: ## Supprimes les fichiers ignorés par Git
	args=; [ ! -z "$(dry_run)" ] && args=n
	git clean -ffdX$${args}
