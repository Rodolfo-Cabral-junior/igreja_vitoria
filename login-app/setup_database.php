<?php

// Criar tabelas manualmente no SQLite
$databasePath = __DIR__ . '/database/database.sqlite';

try {
    $pdo = new PDO('sqlite:' . $databasePath);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar tabela migrations
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS migrations (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            migration VARCHAR(255),
            batch INTEGER
        )
    ");

    // Criar tabela users
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name VARCHAR(255),
            email VARCHAR(255) UNIQUE,
            email_verified_at TIMESTAMP,
            password VARCHAR(255),
            remember_token VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ");

    // Criar tabela sessions
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS sessions (
            id VARCHAR(255) PRIMARY KEY,
            user_id INTEGER,
            ip_address VARCHAR(45),
            user_agent TEXT,
            payload TEXT,
            last_activity INTEGER
        )
    ");

    // Inserir usuário de teste
    $passwordHash = password_hash('123456', PASSWORD_DEFAULT);
    $pdo->exec("
        INSERT OR IGNORE INTO users (name, email, password) 
        VALUES ('Usuário Teste', 'teste@example.com', '$passwordHash')
    ");

    echo "Banco de dados configurado com sucesso!\n";
    echo "Usuário de teste: teste@example.com\n";
    echo "Senha: 123456\n";

} catch (PDOException $e) {
    echo "Erro: " . $e->getMessage() . "\n";
}
