#!/bin/bash

echo "🔧 Configurando Laravel para usar MySQL..."

# Atualizar .env para MySQL
cat > .env << EOF
APP_NAME=Laravel
APP_ENV=local
APP_KEY=base64:Zk/dgUdivLOKDDStGhTPM0w5BQOqzRshTDUChFowF90=
APP_DEBUG=true
APP_URL=http://localhost

APP_LOCALE=pt_BR
APP_FALLBACK_LOCALE=en
APP_FAKER_LOCALE=pt_BR

APP_MAINTENANCE_DRIVER=file

BCRYPT_ROUNDS=12

LOG_CHANNEL=stack
LOG_STACK=single
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=login_sf
DB_USERNAME=root
DB_PASSWORD=

SESSION_DRIVER=database
SESSION_LIFETIME=120
SESSION_ENCRYPT=false
SESSION_PATH=/
SESSION_DOMAIN=null

BROADCAST_CONNECTION=log
FILESYSTEM_DISK=local
QUEUE_CONNECTION=database

CACHE_STORE=database

MEMCACHED_HOST=127.0.0.1

REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
REDIS_PASSWORD=null
REDIS_PORT=6379

MAIL_MAILER=log
MAIL_SCHEME=null
MAIL_HOST=127.0.0.1
MAIL_PORT=2525
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_FROM_ADDRESS="hello@example.com"
MAIL_FROM_NAME="\${APP_NAME}"

VITE_APP_NAME="\${APP_NAME}"
EOF

echo "✅ Arquivo .env atualizado para MySQL"
echo ""
echo "📋 Próximos passos:"
echo "1. Execute: sudo mysql -u root -p < setup_mysql.sql"
echo "2. Se pedir senha, tente: sudo mysql -u root < setup_mysql.sql"
echo "3. Depois execute: php artisan migrate"
echo "4. Teste a aplicação: php artisan serve"
