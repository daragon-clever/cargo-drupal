#!/usr/bin/env sh

eval $(ssh-agent -s)
ssh-add /.ssh/id_rsa

bundle "$@"
