#!/bin/bash

# ===========================
# INSTALLATION DE DOCKER
# ===========================

echo "🚀 Suppression des anciennes versions de Docker..."
for pkg in docker.io docker-doc docker-compose podman-docker containerd runc; do 
  sudo apt-get remove -y $pkg || true
done

echo "📦 Mise à jour du système..."
sudo apt-get update

echo "🔑 Installation des dépendances..."
sudo apt-get install -y ca-certificates curl

echo "🔐 Ajout du dépôt officiel Docker..."
sudo install -m 0755 -d /etc/apt/keyrings
sudo curl -fsSL https://download.docker.com/linux/debian/gpg -o /etc/apt/keyrings/docker.asc
sudo chmod a+r /etc/apt/keyrings/docker.asc

echo "📄 Ajout de la source Docker dans APT..."
echo \
  "deb [arch=$(dpkg --print-architecture) signed-by=/etc/apt/keyrings/docker.asc] https://download.docker.com/linux/debian \
  $(. /etc/os-release && echo "$VERSION_CODENAME") stable" | \
  sudo tee /etc/apt/sources.list.d/docker.list > /dev/null
  
echo "🔄 Mise à jour et installation de Docker..."
sudo apt-get update
sudo apt-get install -y docker-ce docker-ce-cli containerd.io docker-buildx-plugin docker-compose-plugin

echo "📦 Lancement du docker..."
sudo docker run hello-world

# ===========================
# CONFIGURATION DE DOCKER-COMPOSE
# ===========================

echo "🌍 Récupération de l'adresse IP locale..."
IP_ADDRESS=$(ip route get 1 | awk '{print $7; exit}')
echo "🔍 Adresse IP détectée : $IP_ADDRESS"

# Création du dossier de configuration Docker
CONFIG_DIR="/etc/docker/Dockercompose"
SRC_DIR="$CONFIG_DIR/src"
echo "📁 Création des dossiers $CONFIG_DIR et $SRC_DIR..."
sudo mkdir -p $SRC_DIR


echo "✍️ Création du fichier docker-compose.yml..."
sudo tee $CONFIG_DIR/docker-compose.yml > /dev/null <<EOF
version: "3.9"

services:
  www:
    build: ./src
    ports:
      - "8000:80"
    volumes:
      - ./src:/var/www/html
    depends_on:
      - db
    networks:
      - backend

  db:
    image: mysql:latest
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql
    environment:
      MYSQL_DATABASE: docker
      MYSQL_USER: etudiant
      MYSQL_PASSWORD: vitrygtr
      MYSQL_ROOT_PASSWORD: vitrygtr
    networks:
      - backend

  phpmyadmin:
    image: phpmyadmin/phpmyadmin
    ports:
      - "8001:80"
    environment:
      PMA_HOST: db
      MYSQL_USER: etudiant
      MYSQL_PASSWORD: vitrygtr
      MYSQL_ROOT_PASSWORD: vitrygtr
    depends_on:
      - db
    networks:
      - backend

  ldap:
    image: osixia/openldap:latest
    container_name: ldap
    environment:
      LDAP_ORGANISATION: "My Organization"
      LDAP_DOMAIN: "example.com"
      LDAP_ADMIN_PASSWORD: "adminpassword"
    ports:
      - "389:389"
      - "636:636"
    volumes:
      - ldapData:/var/lib/ldap
      - ldapConfig:/etc/ldap/slapd.d
    networks:
      - backend

  ldap_admin:
    image: osixia/phpldapadmin:latest
    container_name: phpldapadmin
    environment:
      PHPLDAPADMIN_LDAP_HOSTS: ldap
      PHPLDAPADMIN_HTTPS: "false"
    ports:
      - "8082:80"
    depends_on:
      - ldap
    networks:
      - backend

  my-keycloak:
    image: quay.io/keycloak/keycloak:24.0
    environment:
      KC_HOSTNAME: "$(hostname -I | awk '{print $1}')"
      KC_HOSTNAME_PORT: 7080
      KC_HOSTNAME_STRICT_BACKCHANNEL: "true"
      KEYCLOAK_ADMIN: admin
      KEYCLOAK_ADMIN_PASSWORD: admin
      KC_HEALTH_ENABLED: "true"
      KC_LOG_LEVEL: info
    healthcheck:
      test: ["CMD", "curl", "-f", "http://$(hostname -I | awk '{print $1}'):7080/health/ready"]
      interval: 15s
      timeout: 2s
      retries: 15
    command: ["start-dev", "--http-port", "7080", "--https-port", "7443"]
    ports:
      - "7080:7080"
      - "7443:7443"
    volumes:
      - keycloak_data:/opt/jboss/keycloak/standalone/data
    networks:
      - backend

volumes:
  db_data:
  ldapData:
  ldapConfig:
  keycloak_data:
  postgres_data:

networks:
  backend:
    driver: bridge
EOF

echo "✅ Fichier docker-compose.yml créé avec l'IP : $IP_ADDRESS"

echo "📦 Déplacement du Dockerfile vers $CONFIG_DIR..."
sudo mv Dockerfile $CONFIG_DIR/

echo "📂 Déplacement du dossier 'Docker' vers $SRC_DIR..."
sudo mv Docker $SRC_DIR/

echo "🚢 Démarrage des conteneurs Docker..."
cd $CONFIG_DIR
docker-compose up -d

echo "✅ Tous les services sont en cours d'exécution."
echo "💻 Accédez à Keycloak sur : http://$IP_ADDRESS:8000"

























