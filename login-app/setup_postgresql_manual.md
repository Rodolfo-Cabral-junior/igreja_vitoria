# Configuração Manual do PostgreSQL

## 1. Criar Banco de Dados e Usuário

Conecte-se ao PostgreSQL como usuário postgres:

```bash
# Método 1: Usando sudo (se tiver privilégios)
sudo -u postgres psql

# Método 2: Conectando diretamente
psql -U postgres -h localhost
```

Dentro do psql, execute:

```sql
-- Criar banco de dados
CREATE DATABASE laravel_db;

-- Criar usuário com senha
CREATE USER laravel_user WITH PASSWORD 'sua_senha';

-- Dar privilégios ao usuário no banco de dados
GRANT ALL PRIVILEGES ON DATABASE laravel_db TO laravel_user;

-- Sair do psql
\q
```

## 2. Configuração DBeaver

### Parâmetros de Conexão:
- **Host**: 127.0.0.1 ou localhost
- **Porta**: 5432
- **Banco de Dados**: laravel_db
- **Usuário**: laravel_user
- **Senha**: sua_senha
- **Driver**: PostgreSQL

### Passos no DBeaver:
1. Abra DBeaver
2. File > New > Database Connection
3. Selecione PostgreSQL
4. Preencha os parâmetros acima
5. Test Connection
6. Finish

## 3. Verificar Conexão Laravel

Após configurar o banco de dados, execute:

```bash
php artisan migrate
```

## 4. Troubleshooting

### Erro de Autenticação:
Se receber erro de autenticação, verifique:
- Senha correta no .env
- Usuário existe no PostgreSQL
- Privilégios concedidos

### Conexão Recusada:
Verifique se PostgreSQL está rodando:
```bash
systemctl status postgresql
```

Reinicie se necessário:
```bash
sudo systemctl restart postgresql
```
