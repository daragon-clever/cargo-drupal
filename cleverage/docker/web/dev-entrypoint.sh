#!/usr/bin/env bash
#
# Point d'entrée Docker pour le développement
#
set -Eeuo pipefail

[ -z "${DEBUG:-}" ] || set -x

# la commande commence par "nginx"
if [ "${1:-}" == "nginx" ]; then

  # change les identifiants utilisateur et groupe de nginx
  # pour refléter ceux de l'utilisateur
  DOCKER_HOST_UID="${DOCKER_HOST_UID:-"1000"}"
  DOCKER_HOST_GID="${DOCKER_HOST_GID:-"1000"}"

  if [ "$( id -u nginx )" -ne "$DOCKER_HOST_UID" ]; then
    usermod -u "$DOCKER_HOST_UID" nginx
  fi

  if [ "$( id -g nginx )" -ne "$DOCKER_HOST_GID" ]; then
    groupmod -g "$DOCKER_HOST_GID" nginx
  fi

  # Correction erreur HTTP 413 – Request Entity Too Large
  if ! grep -q client_max_body_size /etc/nginx/nginx.conf; then
    sed -Ei '/^( )*include \/etc\/nginx\/conf\.d.*/i \    client_max_body_size 200M; \nfastcgi_buffers 8 16k; \nfastcgi_buffer_size 32k;\n' \
      /etc/nginx/nginx.conf
  fi
fi

# exécute la commande
exec "$@"
