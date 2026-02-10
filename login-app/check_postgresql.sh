#!/bin/bash

echo "=== Verificando configuração PostgreSQL ==="

# Verificar se PostgreSQL está rodando
if ! pgrep -x "postgres" > /dev/null; then
    echo "PostgreSQL não está rodando"
    exit 1
fi

# Verificar se porta 5432 está aberta
if ! ss -tlnp | grep 5432 > /dev/null; then
    echo "PostgreSQL não está escutando na porta 5432"
    exit 1
fi

# Testar conexão com psql
echo "Testando conexão PostgreSQL..."
psql -h 127.0.0.1 -p 5432 -U postgres -c "SELECT version();" > /dev/null 2>&1
if [ $? -eq 0 ]; then
    echo "✅ Conexão PostgreSQL bem-sucedida"
else
    echo "❌ Falha na conexão PostgreSQL"
    echo "Você precisa executar manualmente:"
    echo "sudo -u postgres createuser laravel_user"
    echo "sudo -u postgres createdb laravel_db -O laravel_user"
    echo "sudo -u postgres psql -c \"ALTER USER laravel_user PASSWORD 'laravel_password';\""
fi

# Verificar extensão PHP
if php -m | grep -i pgsql > /dev/null; then
    echo "✅ Extensão PostgreSQL para PHP está instalada"
else
    echo "❌ Extensão PostgreSQL para PHP não encontrada"
    echo "Execute: sudo apt install php-pgsql"
fi
