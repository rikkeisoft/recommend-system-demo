#!/bin/bash

[[ ! -z $cf_hostname ]] && export cf_hostname="bookstore.dev"
[[ ! -z $cf_timezone ]] && export cf_timezone="UTC"
[[ ! -z $cf_mariadb_root_password ]] && export cf_mariadb_root_password="rootpass"

export DEBIAN_FRONTEND=noninteractive

echo ">> Setting server's hostname"
sudo hostnamectl set-hostname $cf_hostname

echo ">> Setting server's timezone"
sudo timedatectl set-timezone $cf_timezone

if [[ -f ./chmodr.sh ]]
then
  echo ">> Install 'chmodr' command"
  sudo cp -f ./chmodr.sh /usr/bin/chmodr && \
  sudo chmod a+x /usr/bin/chmodr
fi

echo ">> Enable firewall"
sudo ufw allow proto tcp from any to any port 22
sudo ufw --force enable

echo ">> Install common packages"
sudo apt-get update -y
sudo apt-get install -y git curl wget tree nmap unzip

echo ">> Install NGINX"
sudo apt-get install -y nginx
sudo systemctl start nginx
sudo systemctl enable nginx
sudo ufw allow 80

# install mariadb
echo ">> Install MariaDB"
sudo apt-get install -y mariadb-server mariadb-client
sudo systemctl start mysql
sudo systemctl enable mysql

# allow remote access (required to access from our private network host. Note that this is completely insecure if used in any other way)
sudo mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'%' IDENTIFIED BY '$cf_mariadb_root_password' WITH GRANT OPTION;"
sudo mysql -u root -e "GRANT ALL PRIVILEGES ON *.* TO 'root'@'localhost' IDENTIFIED BY '$cf_mariadb_root_password' WITH GRANT OPTION;"
mysql -u root -p$cf_mariadb_root_password -e "DROP DATABASE IF EXISTS test;"
mysql -u root -p$cf_mariadb_root_password -e "FLUSH PRIVILEGES;"
# Fix MariaDB login issue when it says - Access denied for user 'root'@'localhost'
mysql -u root -p$cf_mariadb_root_password -D mysql -e "UPDATE user SET plugin='' WHERE user='root'; FLUSH PRIVILEGES;"

echo ">> Install Redis"
sudo apt-get install -y redis-server
sudo systemctl start redis-server
sudo systemctl enable redis-server

echo ">> Install PHP7.0"
sudo apt-get install -y php-fpm php-cli php-common php-mbstring php-xml php-curl php-mcrypt php-pdo php-mysqlnd php-redis
sudo systemctl start php7.0-fpm
sudo systemctl enable php7.0-fpm

echo ">> Install Composer"
curl -sSL https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod a+x /usr/local/bin/composer

echo ">> Install Adminer"
curl -sSL https://github.com/vrana/adminer/releases/download/v4.2.5/adminer-4.2.5-mysql-en.php -o /app/source/public/_db.php

if [[ $cf_mariadb_remote_access == true ]]
then
  echo ">> Enable remote access MariaDB"
  sudo sed -i "s/^port\s*=.*/port=$cf_mariadb_port/" /etc/mysql/mariadb.conf.d/50-server.cnf
  sudo sed -i "s/^bind\-address\s*=.*/bind-address=0.0.0.0/" /etc/mysql/mariadb.conf.d/50-server.cnf
  sudo ufw allow $cf_mariadb_port
  sudo systemctl restart mysql
fi

if [[ $cf_redis_remote_access == true ]]
then
  echo ">> Enable remote access Redis"
  sudo sed -i "s/^port\s*6379$/port $cf_redis_port/" /etc/redis/redis.conf
  sudo sed -i "s/^bind\s*127.0.0.1$/bind 0.0.0.0/" /etc/redis/redis.conf
  sudo ufw allow $cf_redis_port
  sudo systemctl restart redis-server
fi

# TODO: set listen from IP of Unix Socket
echo ">> Configure and secure PHP"
PHP_FPM_CONF_PATH=/etc/php/7.0/fpm
sudo sed -i "s/^;date\.timezone\s*=.*/date.timezone=$cf_timezone/" $PHP_FPM_CONF_PATH/php.ini && \
sudo sed -i "s/^;cgi\.fix_pathinfo\s*=.*/cgi.fix_pathinfo=0/" $PHP_FPM_CONF_PATH/php.ini && \
sudo sed -i "s/^short_open_tag\s*=.*/short_open_tag=On/" $PHP_FPM_CONF_PATH/php.ini && \
sudo sed -i "s/^;daemonize\s*=.*/daemonize=no/" $PHP_FPM_CONF_PATH/php-fpm.conf && \
#sudo sed -i "s/^listen\s*=.*/listen=$cf_php_fpm_listen/" $PHP_FPM_CONF_PATH/pool.d/www.conf && \
#sudo sed -i "s/^user\s*=.*/user=$cf_http_user/" $PHP_FPM_CONF_PATH/pool.d/www.conf && \
#sudo sed -i "s/^group\s*=.*/group=$cf_http_group/" $PHP_FPM_CONF_PATH/pool.d/www.conf && \
sudo sed -i "s/^listen\.allowed_clients\s*=.*/listen.allowed_clients=127.0.0.1/" $PHP_FPM_CONF_PATH/pool.d/www.conf && \
sudo sed -i "s/^;catch_workers_output\s*=.*/catch_workers_output=yes/" $PHP_FPM_CONF_PATH/pool.d/www.conf && \
sudo sed -i "s/^php_admin_flag\[log_errors\]\s*=.*/;php_admin_flag[log_errors] =/" $PHP_FPM_CONF_PATH/pool.d/www.conf && \
sudo sed -i "s/^php_admin_value\[error_log\]\s*=.*/;php_admin_value[error_log] =/" $PHP_FPM_CONF_PATH/pool.d/www.conf && \
sudo sed -i "s/^;php_admin_value\[display_errors\]\s*=.*/php_admin_value[display_errors] = 'stderr'/" $PHP_FPM_CONF_PATH/pool.d/www.conf
sudo systemctl restart php7.0-fpm

echo ">> Configure NGINX vhost"
sudo rm -f /etc/nginx/sites-enabled/default
sudo cp -f /vagrant/script/nginx_vhost.conf /etc/nginx/sites-enabled/default
sudo systemctl restart nginx

echo ">> Create database"
mysql -u root -p$cf_mariadb_root_password -e "CREATE DATABASE IF NOT EXISTS homestead;"
mysql -u root -p$cf_mariadb_root_password -e "GRANT ALL ON homestead.* TO 'homestead'@'%' IDENTIFIED BY 'secret';"
mysql -u root -p$cf_mariadb_root_password -e "GRANT ALL ON homestead.* TO 'homestead'@'localhost' IDENTIFIED BY 'secret';"

echo ">> Setup application"
cd /app/source
composer install -vvv --no-progress --no-suggest --no-scripts
composer run-script post-root-package-install
composer run-script post-create-project-cmd
composer run-script post-install-cmd
php artisan cache:clear
php artisan config:clear
php artisan migrate --force --seed

echo ">> Cleanup"
sudo apt-get autoremove -y
