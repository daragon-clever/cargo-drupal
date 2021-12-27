#!/usr/bin/env ash
#
# traefik dev entrypoint
#
set -euo pipefail
[ "${DEBUG:-}" = "true" ] && set -x

# la commande commence par "traefik"
if [ "${1:-}" = "traefik" ]; then

  # installe openssl
  which openssl > /dev/null || apk add --no-cache openssl

  # génère un certificat wildcard auto-signé
  TLS_DIR="${TLS_DIR:-"/etc/ssl/private"}"
  if [ ! -f "${TLS_DIR}/tls.crt" ]; then
    TLS_BASE="${TLS_BASE:-"/O=CleverAge/OU=Docker"}"
    # autorité de certification
    openssl genrsa -out "${TLS_DIR}/ca.key" 2048 2> /dev/null
    openssl req -x509 -new -nodes \
      -key "${TLS_DIR}/ca.key" \
      -sha256 -days 3560 \
      -subj "${TLS_BASE}/CN=${COMPOSE_PROJECT_NAME}" \
      -out "${TLS_DIR}/ca.crt" 2> /dev/null
    # certificat
    openssl genrsa -out "${TLS_DIR}/tls.key" 2048 2> /dev/null
    openssl req -new \
      -key "${TLS_DIR}/tls.key" \
      -out "${TLS_DIR}/tls.csr" \
      -subj "${TLS_BASE}/CN=${TRAEFIK_DOMAIN}" 2> /dev/null
    cat <<-EOF > "${TLS_DIR}/tls.ext"
		authorityKeyIdentifier=keyid,issuer
		basicConstraints=CA:FALSE
		keyUsage=digitalSignature,nonRepudiation,keyEncipherment,dataEncipherment
		subjectAltName=@alt_names
		[alt_names]
		DNS.1 = ${TRAEFIK_DOMAIN}
		DNS.2 = *.${TRAEFIK_DOMAIN}
		EOF
    openssl x509 -req \
      -in "${TLS_DIR}/tls.csr" \
      -CA "${TLS_DIR}/ca.crt" \
      -CAkey "${TLS_DIR}/ca.key" \
      -CAcreateserial \
      -extfile "${TLS_DIR}/tls.ext" \
      -out "${TLS_DIR}/tls.crt" \
      -days 3560 -sha256 2> /dev/null
  fi

  # créé le fichier de configuration de Traefik
  if [ ! -f /etc/traefik.yml ]; then
    cat /opt/traefik/traefik.yml \
      | sed -E "s#%COMPOSE_PROJECT_NAME%#${COMPOSE_PROJECT_NAME}#g;
        s#%TRAEFIK_DOMAIN%#${TRAEFIK_DOMAIN}#g" > /etc/traefik.yml
  fi
fi

# exécute la commande
exec "$@"
