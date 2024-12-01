  echo 'deploy.sh'
  sudo cp deploy/nginx.conf /etc/nginx/conf.d/demo.conf -f
  sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/demo.conf -f
  sudo service nginx restart
  ls -al
  sudo -u www-data composer install -q
  sudo service php8.3-fpm restart
  sudo -u www-data php bin/console doctrine:migrations:migrate --no-interaction
  sudo service supervisor restart
