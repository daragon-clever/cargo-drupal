help/%:: name=$*
help/%:: # Affiche l'ensemble des commandes d'un espace de noms
	quantifier=
	case "$(name)" in
		main|all)
			files="$(MAKEFILE_LIST)"
			[ "$(name)" = "all" ] && quantifier=+ || quantifier=;
		;;
		general) files=cleverage/Makefile; quantifier=+;;
		*) files=cleverage/make/$(name).make; quantifier=+;;
	esac
	grep -EoH '^[^: A-Z]+:[^#]*\#'"$${quantifier}"'\s(.+)' $$files \
	| sed -E 's/^(cleverage\/)?make(file|\/(.*)\.make):([^ #:]+):[^#]*[#]+\s(.+)/\3\|\4|\5/gi; s/^\|/z\|/g' \
	| sort -d | sed -E 's/^z\|/general\|/g; s/\%/\[name\]/g' \
	| awk -F '|' '{
		icon="\360\237\220\247"; color="32";
		if ($$1=="docker") {icon="\360\237\220\263"; color="34"}
		else if ($$1=="db") {icon="\360\237\222\276"; color="36"}
		else if ($$1=="help") {icon="\360\237\222\201"; color="93"}
		else if ($$1=="php") {icon="\360\237\223\234"; color="35"}
		else if ($$1=="drupal"||$$1=="drush") {icon="\360\237\222\247"; color="36"}
		else if ($$1=="tls") {icon="\360\237\224\222"; color="33"}
		printf "\033[%dm%-24s %s %-10s \033[0m%s\n",
		color, $$2, icon, (toupper(substr($$1, 1, 1)) substr($$1, 2)), $$3
	}'

help:: help/main # Affiche cette aide
