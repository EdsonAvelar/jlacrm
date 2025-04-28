#!/usr/bin/env bash

# ================================
# deploy.sh – Atualiza o código e
# provisiona ambiente Laravel
# ================================

# Sai no primeiro erro
set -e

rm -rf .htaccess .well-known/ default.html cgi-bin/

git clone https://github.com/EdsonAvelar/jlacrm.git .
cp htaccess .htaccess
curl -sS https://getcomposer.org/installer | php
composer install --no-dev --optimize-autoloader
cp .env.example .env
vi .env