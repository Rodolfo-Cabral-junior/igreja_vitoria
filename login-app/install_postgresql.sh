#!/bin/bash

echo "=== INSTALANDO POSTGRESQL PARA LARAVEL ==="

# Instalar extensão PostgreSQL para PHP
echo "1. Instalando php-pgsql..."
sudo apt update
sudo apt install -y php-pgsql

# Criar banco de dados e usuário
echo "2. Configurando banco de dados..."
sudo -u postgres createuser laravel_user
sudo -u postgres createdb laravel_db -O laravel_user  
sudo -u postgres psql -c "ALTER USER laravel_user PASSWORD 'laravel_password';"

# Reiniciar Apache
echo "3. Reiniciando Apache..."
sudo systemctl restart apache2

# Verificar instalação
echo "4. Verificando instalação..."
php -m | grep -i pgsql && echo "✅ php-pgsql instalado" || echo "❌ php-pgsql não encontrado"

# Testar conexão
echo "5. Testando conexão com banco..."
psql -h 127.0.0.1 -p 5432 -U laravel_user -d laravel_db -c "SELECT version();" > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo "✅ Conexão PostgreSQL bem-sucedida"
else
    echo "❌ Falha na conexão PostgreSQL"
fi

echo ""
echo "=== EXECUTANDO MIGRAÇÕES ==="
php artisan migrate

echo ""
echo "=== CONCLUÍDO ==="
echo "Projeto configurado e rodando em http://localhost:8000"
