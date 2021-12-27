#!/usr/bin/env bash
#
# Point d'entrée Docker pour le développement
#
set -Eeuo pipefail

[ -z "${DEBUG:-}" ] || set -x

# la commande commence par "php-fpm"
if [ "${1:-}" == "php-fpm" ]; then

  # change les identifiants utilisateur et groupe de www-data
  # pour refléter ceux de l'utilisateur
  DOCKER_HOST_UID="${DOCKER_HOST_UID:-"1000"}"
  DOCKER_HOST_GID="${DOCKER_HOST_GID:-"1000"}"

  if [ "$( id -u www-data )" -ne "$DOCKER_HOST_UID" ]; then
    usermod -u "$DOCKER_HOST_UID" www-data
  fi

  if [ "$( id -g www-data )" -ne "$DOCKER_HOST_GID" ]; then
    groupmod -g "$DOCKER_HOST_GID" www-data
  fi

  # Créé le répertoire COMPOSER_HOME pour le cache composer
  COMPOSER_HOME="${COMPOSER_HOME:-"/var/www/.composer"}"
  mkdir -p $COMPOSER_HOME && chown www-data. $COMPOSER_HOME

  # Configuration de php-fpm pour le développement local
  sed -Ei 's#^(;)?(catch_workers_output =).*#\2 yes#g;
    s#^(;)?(php_admin_value\[error_log\] =.*)#\2#g;
    s#^(;)?(php_admin_flag\[log_errors\] =.*)#\2#g;' \
    /usr/local/etc/php-fpm.d/www.conf
fi

# exécute la commande
exec "$@"
