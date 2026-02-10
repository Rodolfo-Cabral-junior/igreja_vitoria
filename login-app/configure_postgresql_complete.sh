#!/bin/bash

echo "=== CONFIGURAÇÃO COMPLETA POSTGRESQL PARA LARAVEL ==="
echo "Este script precisa ser executado com privilégios sudo"
echo ""

# 1. Instalar extensão PostgreSQL para PHP
echo "1. Instalando extensão PostgreSQL para PHP..."
sudo apt update
sudo apt install -y php-pgsql

# 2. Criar usuário e banco de dados
echo "2. Criando usuário e banco de dados PostgreSQL..."
sudo -u postgres psql -c "DROP USER IF EXISTS laravel_user;"
sudo -u postgres psql -c "DROP DATABASE IF EXISTS laravel_db;"
sudo -u postgres psql -c "CREATE USER laravel_user WITH PASSWORD 'laravel_password';"
sudo -u postgres psql -c "CREATE DATABASE laravel_db OWNER laravel_user;"
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE laravel_db TO laravel_user;"

# 3. Reiniciar serviços web
echo "3. Reiniciando serviços web..."
if systemctl is-active --quiet apache2; then
    sudo systemctl restart apache2
    echo "   Apache reiniciado"
elif systemctl is-active --quiet nginx; then
    sudo systemctl restart nginx
    sudo systemctl restart php$(php -r 'echo PHP_MAJOR_VERSION.".".PHP_MINOR_VERSION;')-fpm
    echo "   Nginx e PHP-FPM reiniciados"
fi

# 4. Verificar configuração
echo "4. Verificando configuração..."
php -m | grep -i pgsql > /dev/null && echo "   ✅ Extensão PostgreSQL PHP instalada" || echo "   ❌ Extensão não encontrada"
sudo -u postgres psql -c "\du laravel_user" > /dev/null 2>&1 && echo "   ✅ Usuário laravel_user criado" || echo "   ❌ Usuário não encontrado"
sudo -u postgres psql -c "\l laravel_db" > /dev/null 2>&1 && echo "   ✅ Banco laravel_db criado" || echo "   ❌ Banco não encontrado"

echo ""
echo "=== CONFIGURAÇÃO CONCLUÍDA ==="
echo "Execute os seguintes comandos no terminal:"
echo "1. cp .env.example .env"
echo "2. php artisan key:generate"
echo "3. Configure o .env com:"
echo "   DB_CONNECTION=pgsql"
echo "   DB_HOST=127.0.0.1"
echo "   DB_PORT=5432"
echo "   DB_DATABASE=laravel_db"
echo "   DB_USERNAME=laravel_user"
echo "   DB_PASSWORD=laravel_password"
echo "4. php artisan migrate"
echo ""
