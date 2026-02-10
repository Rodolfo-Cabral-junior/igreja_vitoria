#!/bin/bash

echo "=== Configurando PostgreSQL para o projeto Laravel ==="

# Criar usuário e banco de dados
sudo -u postgres psql -c "CREATE USER laravel_user WITH PASSWORD 'laravel_password';" 2>/dev/null || echo "Usuário já existe ou erro na criação"
sudo -u postgres psql -c "CREATE DATABASE laravel_db OWNER laravel_user;" 2>/dev/null || echo "Banco já existe ou erro na criação"
sudo -u postgres psql -c "GRANT ALL PRIVILEGES ON DATABASE laravel_db TO laravel_user;"

# Verificar se extensão PostgreSQL para PHP está instalada
if ! php -m | grep -i pgsql > /dev/null; then
    echo "Instalando extensão PostgreSQL para PHP..."
    sudo apt update
    sudo apt install php-pgsql -y
else
    echo "Extensão PostgreSQL para PHP já está instalada"
fi

# Reiniciar Apache/Nginx se necessário
echo "Verificando servidor web..."
if systemctl is-active --quiet apache2; then
    sudo systemctl restart apache2
    echo "Apache reiniciado"
elif systemctl is-active --quiet nginx; then
    sudo systemctl restart nginx
    sudo systemctl restart php-fpm
    echo "Nginx e PHP-FPM reiniciados"
fi

echo "=== Configuração concluída ==="
echo "Banco de dados: laravel_db"
echo "Usuário: laravel_user"
echo "Senha: laravel_password"
