#!/usr/bin/env bash

ssh-add /ssh/id_rsa
service ssh start
php-fpm
