#!/bin/bash

# Verifica se o arquivo .env existe, e se não, copia de .env.example
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
    echo ".env criado a partir de .env.example"
else
    echo ".env já existe"
fi

# Carrega as variáveis de ambiente do .env
export $(grep -v '^#' /var/www/html/.env | xargs)

# Imprime as variáveis de ambiente para debug
echo "DB_SERVERNAME: $DB_SERVERNAME"
echo "DB_USERNAME: $DB_USERNAME"
echo "DB_PASSWORD: $DB_PASSWORD"
echo "DB_NAME: $DB_NAME"
