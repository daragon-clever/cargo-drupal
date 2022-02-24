# [CleverAge](../README.md) - Variables d'environnement

| Nom | Valeur | Description |
|--   |--      |--           |
| `DOCKER_BUILDKIT`| `1` | Active l'optimisation de la construction des images Docker avec [BuildKit](https://docs.docker.com/develop/develop-images/build_enhancements/#to-enable-buildkit-builds) |
| `BUILDKIT_INLINE_CACHE` | `1` | Active l'utilisation d'images Docker avec le [cache BuildKit](https://docs.docker.com/engine/reference/commandline/build/#specifying-external-cache-sources) |
| `COMPOSE_DOCKER_CLI_BUILD` | `1` | Active le build natif Docker à travers [docker-compose](https://docs.docker.com/compose/reference/envvars/#compose_docker_cli_build) |
| `COMPOSE_PROJECT_NAME` | `cargo` | Défini le [nom de projet docker-compose](https://docs.docker.com/compose/reference/envvars/#compose_project_name) |
| `COMPOSE_FILE` | [cleverage-compose.yml](../../cleverage-compose.yml) | Le chemin vers un où plusieurs [fichiers docker-compose](https://docs.docker.com/compose/reference/envvars/#compose_file). Sur MacOS le fichier [cleverage-compose.mac.yml](../../cleverage-compose.mac.yml) est ajouté à la variable `COMPOSE_FILE` lors de la création du fichier `cleverage.env` |
| `COMPOSE_PATH_SEPARATOR` | `:` | Le séparateur de chemins des [fichiers docker-compose](https://docs.docker.com/compose/reference/envvars/#compose_path_separator)  |
| `COMPOSE_CONVERT_WINDOWS_PATHS` | `1` | Active la conversion des chemins windows au format unix dans les [définitions des volumes](https://docs.docker.com/compose/reference/envvars/#compose_convert_windows_paths) |
| `DOCKER_HOST_PLATFORM` | auto | Le système d'exploitation de l'utilisateur, résolu automatiquement lors de la création du fichier `cleverage.env` |
| `DOCKER_HOST_UID` | auto | L'identifiant de l'utilisateur, résolu automatiquement lors de la création du fichier `cleverage.env` |
| `DOCKER_HOST_GID` | auto | L'identifiant du groupe de l'utilisateur, résolu automatiquement lors de la création du fichier `cleverage.env` |
| `TRAEFIK_DOMAIN` | `cargo.local` | Le nom de domaine HTTP du projet ainsi que le nom commun du certificat TLS généré par Traefik. Peut être modifié à la création du fichier `cleverage.env` avec le paramètre `domain`, par exemple : `make domain=cargo.localhost` |
