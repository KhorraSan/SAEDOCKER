
# Utiliser PHP 8.2 RC avec Apache comme image de base
FROM php:8.2-rc-apache

# Installer les dépendances pour les extensions MySQLi, PDO et LDAP
RUN apt-get update && apt-get install -y \
    libldap2-dev \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install ldap \
    && docker-php-ext-enable mysqli ldap pdo pdo_mysql

# Activer le module Apache rewrite si nécessaire
RUN a2enmod rewrite

# Copier le code source de l'application dans le container
COPY src/ /var/www/html/

# Exposer le port 80 (port par défaut d'Apache)
EXPOSE 80
