DRUSH_ARGS	:=
ifdef DEBUG
DRUSH_ARGS	+= -vvv
endif

dr/%: name=$*
dr/%: # Exécute une commande Drush dans le conteneur php
	workdir=/var/www/html
	if [ ! -z "$(site)" ]; then
		if [ ! -d "web/sites/$(site)" ]; then
			echo "Erreur, le répertoire 'web/sites/$(site)' n'existe pas"
			exit 1
		fi
		workdir="$${workdir}/web/sites/$(site)"
		if [ ! -f "web/sites/$(site)/settings.php" ]; then
			if [ ! -f "web/sites/$(site)/settings.php.dist" ]; then
				echo "Erreur, le fichier 'web/sites/$(site)/settings.php.dist' n'existe pas"
				exit 1
			fi
			cp web/sites/$(site)/settings.php.dist web/sites/$(site)/settings.php
		fi
		if [ ! -f web/sites/$(site)/settings.local.php ]; then
			cp sites/example.settings.local.php web/sites/$(site)/settings.local.php
		fi
		if ! grep -q "'$(site)'" web/sites/sites.php; then
			sed -Ei "/^(\]|\));.*/i \    '$(site).$(TRAEFIK_DOMAIN)' => '$(site)'," \
				web/sites/sites.php
		fi
	fi
	$(MAKE) php/exec args=$(dockerargs) \
		workdir=$${workdir} \
		cmd="drush $(DRUSH_ARGS) $(name) $(args)"

dr/install: # Installe un où plusieurs sites Drupal avec Drush
	[ -z "$(sites)" ] && { cat <<-'EOF'
		Usage :
		    make $(@) sites [options]
		Arguments :
		    - sites     Le(s) site(s) à installer
		Options:
		    - args      Arguments Drush supplémentaires
		Exemples:
		    make $(@) sites=sema-design
		    make $(@) sites="sema-design genevieve-lethu"
		EOF
		exit 0
	}
	for site in $(sites); do
		dbName="$$( $(MAKE) dr/core-status site="$${site}" \
			| grep 'DB name' | sed -E 's#.*:[ ]*([^ ]+).*#\1#gi' )"
		if [ -z "$${dbName}" ]; then
			echo "Erreur : impossible de résoudre le nom de la base de données du site '$${site}'"
			exit 1
		fi
		$(MAKE) db/create name="$${dbName}"
		args="$(args) --yes"
		[ -d "web/sites/$${site}/config" ] && args="$${args} --existing-config"
		$(MAKE) dr/site-install site="$${site}" args="$${args}"
	done
