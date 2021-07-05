#!/usr/bin/env bash

# Based on https://github.com/danlynn/ember-cli-docker-template/blob/master/setup.sh

# Note that this will automatically be ran if you have rvm installed.
# This shell file sets up the following aliases whenever you cd into
# the current directory tree:
#
# + php
# + composer
#
# If rvm is not installed then you can simply run:
#   . cli-setup.sh
#
# Note that these aliases revert back to executing the system version
# of each command whenever you exit the current project dir tree.

PREV_ROOT_DIR=$(readlink -f $( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )/..)
VOLUME_PATH=$(pwd)
INET_ADDR="172.17.0.1"
DOCKER_TERM_OPTS="-it --init"
DOCKER_PHP="php";
DOCKER_COMPOSER="composer";
COMPOSER_AUTH=\''{"http-basic":{"repo.packagist.com":{"username":"token","password":"d84aa5a819bf0df1f7226bb9d3dc3d003f4b4d8c0ebf4a8245af58605c33"}}}'\';
SSH_CLIENT_IP=$(echo ${SSH_CLIENT} | awk '{ print $1}')

function dockerBuild() {
    if [[ $PWD/ = $PREV_ROOT_DIR/* ]]; then
        args=( "$@" )
        eval "docker build ../../docker/${1}/. -t ${1}-drupal"
    fi
}

function php() {

    if [[ "$(docker images -q php-cli-drupal 2> /dev/null)" == "" ]]; then
      dockerBuild php-cli
    fi

    if [[ $PWD/ = $PREV_ROOT_DIR/* ]]; then
        args=( "$@" )
        eval "docker run ${DOCKER_TERM_OPTS} --rm \
            --user $(id -u):$(id -g) \
            --ipc=host \
            --network=host \
            --network=webgateway \
            $(makeEnv) \
            -e XDEBUG_CONFIG=\"client_host=${SSH_CLIENT_IP}\" \
            -e PHP_IDE_CONFIG=\"serverName=drupal\" \
            -v $VOLUME_PATH../../../:/var/www/html \
            -w /var/www/html \
            --entrypoint=/usr/local/bin/php \
            php-cli-drupal " "${args[@]}"
    else
        `which php` $@
    fi
}

function composer() {

    if [[ "$(docker images -q php-cli-drupal 2> /dev/null)" == "" ]]; then
      dockerBuild php-cli
    fi

    if [[ $PWD/ = $PREV_ROOT_DIR/* ]]; then
        eval "docker run ${DOCKER_TERM_OPTS} --rm \
            --user $(id -u):$(id -g) \
            --ipc=host \
            --network=host \
            --network=webgateway \
            $(makeEnv) \
            -v $VOLUME_PATH../../../:/var/www/html \
            -w /var/www/html \
            -e COMPOSER_AUTH="$COMPOSER_AUTH" \
            -e COMPOSER_HOME=/home/composer/composer \
            --entrypoint=/usr/local/bin/php \
            php-cli-drupal \
            -dmemory_limit=-1 /usr/local/bin/composer" $@
    else
        `which composer` $@
    fi
}

function makeEnv() {
    envList=""

    for NAME in `compgen -e`
    do
        envList="${envList} -e ${NAME}=\"$(printenv ${NAME})\""
    done

    echo "$envList"
}

