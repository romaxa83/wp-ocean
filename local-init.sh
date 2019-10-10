#!/bin/bash
set | egrep '^(MYSQL_DATABASE|MYSQL_USER|MYSQL_PASSWORD)=' > /etc/environment

\cp /var/www/html/common/config/main-local.php.dist /var/www/html/common/config/main-local.php

sed -i -- "s~{NAME}~$MYSQL_DATABASE~g" /var/www/html/common/config/main-local.php
sed -i -- "s~{USER}~$MYSQL_USER~g" /var/www/html/common/config/main-local.php
sed -i -- "s~{PASSWORD}~$MYSQL_PASSWORD~g" /var/www/html/common/config/main-local.php
sed -i -- "s~localhost~mariadb~g" /var/www/html/common/config/main-local.php

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php
php -r "unlink('composer-setup.php');"
php composer.phar install
php composer.phar update
php -r "unlink('composer.phar');"

php init --env=Development --overwrite=No
