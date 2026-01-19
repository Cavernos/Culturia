#!/bin/sh
if ["$ENV" = "production"]; then
  echo "Mode $ENV : Lancement du de fast-cgi"
  php-fpm
else
  echo "Mode développement : Installation des dépendances et lancement du serveur interne"
  composer install
  php migrator.php migrate
  php -S 0.0.0.0:8000 -t public
fi