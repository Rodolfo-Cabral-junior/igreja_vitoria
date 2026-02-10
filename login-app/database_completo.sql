-- ========================================
-- BANCO DE DADOS COMPLETO COM RELACIONAMENTOS
-- ========================================

-- Criar banco de dados
CREATE DATABASE IF NOT EXISTS login_sf CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar o banco de dados
USE login_sf;

-- ========================================
-- TABELA PRINCIPAL: USERS
-- ========================================
CREATE TABLE users (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    username VARCHAR(255) UNIQUE NOT NULL,
    role ENUM('admin', 'user') DEFAULT 'user' NOT NULL,
    email_verified_at TIMESTAMP NULL,
    password VARCHAR(255) NOT NULL,
    remember_token VARCHAR(100) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    -- Índices para performance
    INDEX idx_users_email (email),
    INDEX idx_users_username (username),
    INDEX idx_users_role (role),
    INDEX idx_users_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABELA DE PERFIS (Relacionamento 1:1)
-- ========================================
CREATE TABLE profiles (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED UNIQUE NOT NULL,
    bio TEXT NULL,
    phone VARCHAR(20) NULL,
    address TEXT NULL,
    birth_date DATE NULL,
    avatar VARCHAR(255) NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_profiles_user_id (user_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABELA DE LOGS DE ATIVIDADE (Relacionamento 1:N)
-- ========================================
CREATE TABLE activity_logs (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    action VARCHAR(100) NOT NULL,
    description TEXT NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    INDEX idx_activity_logs_user_id (user_id),
    INDEX idx_activity_logs_action (action),
    INDEX idx_activity_logs_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABELA DE PERMISSÕES
-- ========================================
CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABELA PIVOT: PERMISSÕES DE USUÁRIO (Relacionamento N:M)
-- ========================================
CREATE TABLE user_permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id BIGINT UNSIGNED NOT NULL,
    permission_id BIGINT UNSIGNED NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    
    UNIQUE KEY unique_user_permission (user_id, permission_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (permission_id) REFERENCES permissions(id) ON DELETE CASCADE,
    INDEX idx_user_permissions_user_id (user_id),
    INDEX idx_user_permissions_permission_id (permission_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABELA DE SESSÕES (Laravel)
-- ========================================
CREATE TABLE sessions (
    id VARCHAR(255) PRIMARY KEY,
    user_id BIGINT UNSIGNED NULL,
    ip_address VARCHAR(45) NULL,
    user_agent TEXT NULL,
    payload LONGTEXT NOT NULL,
    last_activity INT UNSIGNED NOT NULL,
    
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
    INDEX sessions_user_id_index (user_id),
    INDEX sessions_last_activity_index (last_activity)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- TABELA MIGRATIONS (Laravel)
-- ========================================
CREATE TABLE migrations (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    migration VARCHAR(255) NOT NULL,
    batch INT NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ========================================
-- INSERIR DADOS INICIAIS
-- ========================================

-- Usuários iniciais
INSERT INTO users (name, email, username, role, password) VALUES
('PASTOR', 'PASTOR@ADMIN.COM', 'PASTOR', 'admin', '$2y$12$fa6xEVjcz45n4hGwHZrHyOuDyxvOtdak23b988AHzFc6vCx.kReWm'),
('Usuário Teste', 'TESTE@EXAMPLE.COM', 'TESTE', 'user', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Perfis iniciais
INSERT INTO profiles (user_id, bio, phone) VALUES
(1, 'Administrador principal do sistema', '(00) 0000-0000'),
(2, 'Usuário de teste do sistema', '(00) 1111-1111');

-- Permissões do sistema
INSERT INTO permissions (name, description) VALUES
('view_dashboard', 'Visualizar Dashboard'),
('create_users', 'Criar Usuários'),
('edit_users', 'Editar Usuários'),
('delete_users', 'Excluir Usuários'),
('view_logs', 'Visualizar Logs de Atividade'),
('manage_permissions', 'Gerenciar Permissões');

-- Atribuir permissões aos usuários
INSERT INTO user_permissions (user_id, permission_id) VALUES
-- Admin: todas as permissões
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5), (1, 6),
-- User comum: apenas visualizar dashboard
(2, 1);

-- Logs iniciais
INSERT INTO activity_logs (user_id, action, description, ip_address) VALUES
(1, 'system_setup', 'Sistema inicializado e configurado', '127.0.0.1'),
(2, 'user_created', 'Usuário de teste criado automaticamente', '127.0.0.1');

-- ========================================
-- VERIFICAÇÃO FINAL
-- ========================================
SELECT 'BANCO DE DADOS CRIADO COM SUCESSO!' as status;
SELECT 'Tabelas criadas:' as info;
SHOW TABLES;
SELECT 'Usuários criados:' as info;
SELECT COUNT(*) as total FROM users;
SELECT 'Relacionamentos configurados:' as info;
SELECT 
    TABLE_NAME,
    COLUMN_NAME,
    REFERENCED_TABLE_NAME,
    REFERENCED_COLUMN_NAME
FROM 
    INFORMATION_SCHEMA.KEY_COLUMN_USAGE 
WHERE 
    TABLE_SCHEMA = 'login_sf' 
    AND REFERENCED_TABLE_NAME IS NOT NULL;
