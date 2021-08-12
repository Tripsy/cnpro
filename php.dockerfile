FROM php:7.4-apache

COPY ./.config/cnp.test.conf /etc/apache2/sites-available/cnp.test.conf

#enable virtual host file from sites-available create a symbolic link from the virtual host file to the sites-enabled directory, which is read by apache2 during startup
RUN a2ensite cnp.test

#Set the 'ServerName' directive globally
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

#Run a configuration file syntax test. It parses the configuration files and either reports Syntax Ok or detailed information about the particular syntax error. This is equivalent to apachectl -t.
RUN apachectl configtest

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN a2enmod rewrite