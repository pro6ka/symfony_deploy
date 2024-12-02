sudo cp deploy/nginx.conf /etc/nginx/conf.d/demo.conf -f
sudo cp deploy/supervisor.conf /etc/supervisor/conf.d/demo.conf -f
sudo service nginx restart
sudo service php8.3-fpm restart
sudo -u www-data php bin/console cache:clear
sudo service supervisor restart
