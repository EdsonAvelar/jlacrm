#!/usr/bin/env bash

# ================================
# deploy.sh – Atualiza o código e
# provisiona ambiente Laravel
# ================================

# Sai no primeiro erro
set -e


echo "==> 1. Atualizando código com Git"
git pull

echo "==> 2. Instalando dependências PHP (Composer)"
# composer install para instalar versões fixas em composer.lock
composer update --no-interaction --prefer-dist --optimize-autoloader

# ou, se quiser sempre pegar as últimas versões definidas em composer.json:
# composer update --no-interaction --prefer-dist --optimize-autoloader

echo "==> 3. Rodando migrations"
php artisan migrate --force

echo "==> 4. Limpando caches antigos"
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear


echo "==> 6. Opcional: rodar outros comandos"
# php artisan queue:restart
# npm ci && npm run production

echo "✅ Deploy finalizado com sucesso!"
