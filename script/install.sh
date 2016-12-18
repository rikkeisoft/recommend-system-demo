#!/bin/bash

[[ ! -z $cf_hostname ]] && export cf_hostname="bookstore.dev"
[[ ! -z $cf_timezone ]] && export cf_timezone="UTC"

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
sudo apt-get update -qq
sudo apt-get install -qq curl nmap tree git make gcc wget openssl

echo ">> Install NGINX"
sudo apt-get install -qq nginx
sudo systemctl start nginx
sudo systemctl enable nginx
sudo ufw allow 80

echo ">> Install MariaDB"
sudo apt-get install -qq mariadb-server
sudo systemctl start mysql
sudo systemctl enable mysql

if [[ $cf_mariadb_remote_access == true ]]
then
  echo ">> Enable remote access MariaDB"
  sudo sed -i "s/^port\s*=.*/port=$cf_mariadb_port/" /etc/mysql/mariadb.conf.d/50-server.cnf
  sudo sed -i "s/^bind\-address\s*=.*/bind-address=0.0.0.0/" /etc/mysql/mariadb.conf.d/50-server.cnf
  sudo ufw allow $cf_mariadb_port
fi

echo ">> Install Redis"
sudo apt-get install -qq redis-server
sudo systemctl start redis-server
sudo systemctl enable redis-server

if [[ $cf_redis_remote_access == true ]]
then
  echo ">> Enable remote access Redis"
  sudo sed -i "s/^port\s*6379$/port $cf_redis_port/" /etc/redis/redis.conf
  sudo sed -i "s/^bind\s*127.0.0.1$/bind 0.0.0.0/" /etc/redis/redis.conf
  sudo ufw allow $cf_redis_port
fi

echo ">> Install PHP7.0"
sudo apt-get install -qq php-fpm php-cli php-common php-mbstring php-xml php-curl php-mcrypt php-redis
sudo systemctl start php7.0-fpm
sudo systemctl enable php7.0-fpm

#sed /etc/php/7.0/fpm/pool.d/www.conf
#listen /run/php/php7.0-fpm.sock

sudo rm -f /etc/nginx/sites-enabled/default
sudo cp -f /vagrant/script/nginx_vhost.conf /etc/nginx/sites-enabled/default
sudo systemctl restart nginx

echo ">> Install Composer"
curl -sSL https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
sudo chmod a+x /usr/local/bin/composer

sudo apt-get autoremove -qq
