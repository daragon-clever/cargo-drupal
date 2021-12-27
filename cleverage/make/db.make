MYSQL	:= mysql -u root -proot

db/exec: ## Exécute une commande dans le conteneur mariadb
	user="$(user)"; [ -z "$${user}" ] && user=mysql
	$(MAKE) dc/exec service=db user=$${user}

db/shell: ## Ouvre un terminal dans le conteneur mariadb
	$(MAKE) db/exec cmd=bash

db/mysql: ## Ouvre un terminal Mysql dans le conteneur mariadb
	$(MAKE) db/exec args="$(dockerargs)" cmd="$(MYSQL) $(args)"

db/query: ## Exécute une instruction Mysql dans le conteneur mariadb
	[ -z "$(sql)" ] && { cat <<-'EOF'
		Usage :
		    make $(@) sql
		Arguments :
		    - sql     L'instruction Mysql à exécuter
		Exemples:
		    make $(@) sql="SHOW DATABASES;"
		    make $(@) sql="CREATE DATABASE foo;"
		EOF
		exit 0
	}
	$(MAKE) db/mysql args="-e '$(sql)'"

db/list: # Liste les bases de données
	$(MAKE) db/query sql="SHOW DATABASES;"

db/create: # Créé une nouvelle base de données
	[ -z "$(name)" ] && { cat <<-'EOF'
		Usage :
		    make $(@) name
		Arguments :
		    - name    Le nom de la base de données à créer
		Exemples:
		    make $(@) name=foo
		    make $(@) name=bar
		EOF
		exit 0
	}
	$(MAKE) db/query sql="CREATE DATABASE IF NOT EXISTS $(name) \
		CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

db/drop: # Supprime une base de données
	[ -z "$(name)" ] && { cat <<-'EOF'
		Usage :
		    make $(@) name
		Arguments :
		    - name    Le nom de la base de données à supprimer
		Exemples:
		    make $(@) name=foo
		    make $(@) name=bar
		EOF
		exit 0
	}
	$(MAKE) db/query sql="DROP DATABASE IF EXISTS $(name);"
