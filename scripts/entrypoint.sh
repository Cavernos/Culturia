#!/bin/sh
if [ "${ENV:-}" = "production" ]; then
  echo "Mode $ENV : Lancement de fast-cgi"
  php-fpm
else
  echo "Mode développement : Serveur PHP interne"
  echo "Mise à jour et installation des dépendances"
  composer update && composer install --prefer-dist
  mkdir -p ./public/upload/artworks
  cp ./public/assets/img/oeuvre_1.png ./public/upload/artworks/oeuvre_1.png
  cp ./public/assets/img/oeuvre_2.png ./public/upload/artworks/oeuvre_2.png
  cp ./public/assets/img/oeuvre_3.png ./public/upload/artworks/oeuvre_3.png
  cp ./public/assets/img/oeuvre_4.png ./public/upload/artworks/oeuvre_4.png
  cp ./public/assets/img/oeuvre_1.png ./public/upload/artworks/oeuvre_1_thumb.png
  cp ./public/assets/img/oeuvre_2.png ./public/upload/artworks/oeuvre_2_thumb.png
  cp ./public/assets/img/oeuvre_3.png ./public/upload/artworks/oeuvre_3_thumb.png
  cp ./public/assets/img/oeuvre_4.png ./public/upload/artworks/oeuvre_4_thumb.png
  echo "Migration de la base de données"
  php migrator.php migrate
  php migrator.php seed -s ArtistsSeeder
  php migrator.php seed -s OrderSeeder
  php migrator.php seed
  echo "Lancement du serveur de développement"
  php -S 0.0.0.0:8000 -t public
fi