FROM chaplean/php:7.1
MAINTAINER Tom - Chaplean <tom@chaplean.coop>

# Update the default apache site with the config of the project.
ADD app/config/apache-vhost.conf /etc/apache2/sites-enabled/000-default.conf
RUN sed 's/^export APACHE_RUN_GROUP=www-data$/export APACHE_RUN_GROUP=root/g' -i /etc/apache2/envvars

ENV COMPOSER_HOME=${HOME}/cache/composer
ENV VIRTUAL_HOST localhost

# Workdir
VOLUME /var/www/symfony
WORKDIR /var/www/symfony/
