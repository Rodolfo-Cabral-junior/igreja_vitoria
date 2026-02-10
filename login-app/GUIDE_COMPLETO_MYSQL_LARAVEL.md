# 🗄️ GUIA COMPLETO: Integração MySQL + Laravel Dashboard Admin

## 📋 PASSO A PASSO COMPLETO

### 🔥 PASSO 1: Configurar Banco de Dados MySQL

#### 1.1 Criar Banco Manualmente
```sql
-- Conecte ao MySQL
mysql -u root -p

-- Criar banco
CREATE DATABASE login_sf CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Usar o banco
USE login_sf;
```

#### 1.2 Criar Tabelas com Relacionamentos
```sql
-- Tabela de Usuários (Principal)
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
    INDEX idx_users_role (role)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela de Perfis (Relacionamento 1:1)
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

-- Tabela de Logs de Atividade (Relacionamento 1:N)
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

-- Tabela de Permissões (Relacionamento N:M)
CREATE TABLE permissions (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) UNIQUE NOT NULL,
    description TEXT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Tabela Pivot de Permissões de Usuário
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

-- Inserir dados iniciais
INSERT INTO users (name, email, username, role, password) VALUES
('PASTOR', 'PASTOR@ADMIN.COM', 'PASTOR', 'admin', '$2y$12$fa6xEVjcz45n4hGwHZrHyOuDyxvOtdak23b988AHzFc6vCx.kReWm'),
('Usuário Teste', 'TESTE@EXAMPLE.COM', 'TESTE', 'user', '$2y$12$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

INSERT INTO permissions (name, description) VALUES
('view_dashboard', 'Visualizar Dashboard'),
('create_users', 'Criar Usuários'),
('edit_users', 'Editar Usuários'),
('delete_users', 'Excluir Usuários'),
('view_logs', 'Visualizar Logs');

INSERT INTO user_permissions (user_id, permission_id) VALUES
(1, 1), (1, 2), (1, 3), (1, 4), (1, 5); -- Admin tem todas permissões
(2, 1); -- User comum só pode ver dashboard
```

### 🔥 PASSO 2: Configurar Laravel para MySQL

#### 2.1 Atualizar .env
```bash
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=login_sf
DB_USERNAME=root
DB_PASSWORD=
```

#### 2.2 Criar Models com Relacionamentos
```php
// app/Models/User.php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'username', 'role', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relacionamentos
    public function profile(): HasOne
    {
        return $this->hasOne(Profile::class);
    }

    public function activityLogs(): HasMany
    {
        return $this->hasMany(ActivityLog::class);
    }

    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'user_permissions');
    }

    // Métodos auxiliares
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }
}

// app/Models/Profile.php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'bio', 'phone', 'address', 'birth_date', 'avatar'
    ];

    protected $casts = [
        'birth_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

// app/Models/ActivityLog.php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'action', 'description', 'ip_address', 'user_agent'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}

// app/Models/Permission.php
<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }
}
```

### 🔥 PASSO 3: Criar Migrations

#### 3.1 Migration de Usuários
```bash
php artisan make:migration create_users_table
```

#### 3.2 Migration de Perfis
```bash
php artisan make:migration create_profiles_table
```

#### 3.3 Migration de Activity Logs
```bash
php artisan make:migration create_activity_logs_table
```

#### 3.4 Migration de Permissões
```bash
php artisan make:migration create_permissions_table
php artisan make:migration create_user_permissions_table
```

### 🔥 PASSO 4: Atualizar Controllers

#### 4.1 DashboardController com Relacionamentos
```php
<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class DashboardController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth.admin');
    }

    public function index()
    {
        $users = User::with('profile')->orderBy('created_at', 'desc')->get();
        $stats = [
            'total' => $users->count(),
            'admins' => $users->where('role', 'admin')->count(),
            'users' => $users->where('role', 'user')->count(),
            'recent' => ActivityLog::with('user')->orderBy('created_at', 'desc')->limit(5)->get()
        ];
        
        return view('admin.dashboard', compact('users', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'username' => 'required|string|max:255|unique:users',
            'role' => ['required', Rule::in(['admin', 'user'])],
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
        ]);

        // Criar perfil vazio
        $user->profile()->create([]);

        // Log da atividade
        ActivityLog::create([
            'user_id' => session('user')->id,
            'action' => 'user_created',
            'description' => "Usuário {$user->name} foi criado",
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent()
        ]);

        return redirect()->route('admin.dashboard')
            ->with('success', 'Usuário criado com sucesso!');
    }

    // Demais métodos...
}
```

### 🔥 PASSO 5: Atualizar Views

#### 5.1 Dashboard com Estatísticas
```blade
<!-- resources/views/admin/dashboard.blade.php -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Total Usuários</h3>
        <p class="text-3xl font-bold text-blue-600">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Administradores</h3>
        <p class="text-3xl font-bold text-purple-600">{{ $stats['admins'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Usuários Comuns</h3>
        <p class="text-3xl font-bold text-gray-600">{{ $stats['users'] }}</p>
    </div>
    <div class="bg-white rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Atividades Recentes</h3>
        <p class="text-3xl font-bold text-green-600">{{ $stats['recent']->count() }}</p>
    </div>
</div>

<!-- Tabela de usuários com relacionamentos -->
<table class="min-w-full table-auto">
    <thead>
        <tr>
            <th class="px-4 py-2 text-left">Nome</th>
            <th class="px-4 py-2 text-left">Email</th>
            <th class="px-4 py-2 text-left">Perfil</th>
            <th class="px-4 py-2 text-left">Função</th>
            <th class="px-4 py-2 text-left">Ações</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
        <tr>
            <td>{{ $user->name }}</td>
            <td>{{ $user->email }}</td>
            <td>
                @if($user->profile)
                    {{ $user->profile->phone ?? 'Sem telefone' }}
                @else
                    <span class="text-gray-400">Sem perfil</span>
                @endif
            </td>
            <td>
                <span class="{{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }} px-2 py-1 rounded-full text-xs">
                    {{ $user->role === 'admin' ? 'Admin' : 'User' }}
                </span>
            </td>
            <td>
                <!-- Botões de ação -->
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
```

### 🔥 PASSO 6: Testar Integração

#### 6.1 Executar Migrations
```bash
php artisan migrate
```

#### 6.2 Testar Sistema
```bash
php artisan serve
```

#### 6.3 Verificar no MySQL Workbench
- Conecte ao banco `login_sf`
- Veja as tabelas criadas
- Verifique os relacionamentos nas abas "Foreign Keys"

### 🔥 PASSO 7: Seeders (Dados Iniciais)

#### 7.1 Criar Seeder
```bash
php artisan make:seeder DatabaseSeeder
```

#### 7.2 Povoar Banco Automaticamente
```bash
php artisan db:seed
```

## 🎯 BENEFÍCIOS DESTA ESTRUTURA:

✅ **Relacionamentos 1:1** (User ↔ Profile)  
✅ **Relacionamentos 1:N** (User → ActivityLogs)  
✅ **Relacionamentos N:M** (Users ↔ Permissions)  
✅ **Integridade Referencial** (Foreign Keys)  
✅ **Performance** (Índices otimizados)  
✅ **Escalabilidade** (Estrutura normalizada)  
✅ **Logs de Auditoria** (ActivityLogs)  
✅ **Sistema de Permissões** (Flexível)  

## 🚀 PRÓXIMOS PASSOS:

1. Implementar sistema de arquivos (uploads)
2. Adicionar API REST
3. Implementar cache (Redis)
4. Adicionar testes automatizados
5. Deploy em produção

Este guia cria uma base sólida e escalável para seu dashboard admin! 🎉
