tls.crt: # Exporte le certificat auto-signé à importer dans votre navigateur
	$(MAKE) dc/exec args=-T service=traefik \
		cmd="cat /etc/ssl/private/ca.crt" > tls.crt

tls/certinfo:: # Affiche les informations du certificat
	$(MAKE) dc/exec service=traefik cmd="openssl x509 -noout -text \
		-in /etc/ssl/private/tls.crt \
		-certopt no_version,no_serial,no_signame,no_pubkey,no_sigdump \
		| sed 's/^[ ]+/ /g'"
