  sudo rm -rf /etc/nginx/conf.d/demo.conf
  sudo cp deploy/nginx.conf /etc/nginx/conf.d/demo.conf -f
  sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/demo.conf -f
  sudo service nginx restart
  sudo -u www-data composer install -q
  sudo service php8.3-fpm restart
  # sudo -u www-data sed -i -- "s|%DATABASE_HOST%|$1|g" .env
  # sudo -u www-data sed -i -- "s|%DATABASE_USER%|$2|g" .env
  # sudo -u www-data sed -i -- "s|%DATABASE_PASSWORD%|$3|g" .env
  # sudo -u www-data sed -i -- "s|%DATABASE_NAME%|$4|g" .env
  sudo -u www-data php bin/console doctrine:migrations:migrate --no-interaction
  # sudo -u www-data sed -i -- "s|%RABBITMQ_HOST%|$5|g" .env
  # sudo -u www-data sed -i -- "s|%RABBITMQ_USER%|$6|g" .env
  # sudo -u www-data sed -i -- "s|%RABBITMQ_PASSWORD%|$7|g" .env
  sudo service supervisor restart
