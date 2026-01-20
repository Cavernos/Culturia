#!/bin/bash
if [ "${ENV:-}" = "production" ]; then
  echo "Mode $ENV : Lancement de fast-cgi"
  php-fpm
else
  echo "Mode développement : Serveur PHP interne"
  echo "Mise à jour et installation des dépendances"
  composer update && composer install --prefer-dist
  echo "Migration de la base de données"
  php migrator.php migrate
  php migrator.php seed -s ArtistsSeeder
  php migrator.php seed -s OrderSeeder
  php migrator.php seed
  echo "Lancement du serveur de développement"
  php -S 0.0.0.0:8000 -t public
fi