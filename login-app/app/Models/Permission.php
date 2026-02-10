<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Permission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description'
    ];

    /**
     * Relacionamento N:M com Users
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_permissions');
    }

    /**
     * Obter permissões por grupo
     */
    public static function getByGroup(): array
    {
        return [
            'dashboard' => self::where('name', 'like', 'view_%')->get(),
            'users' => self::where('name', 'like', '%_users')->get(),
            'system' => self::where('name', 'like', '%_permissions')->get(),
            'logs' => self::where('name', 'like', '%_logs')->get(),
        ];
    }

    /**
     * Verificar se é permissão de visualização
     */
    public function isViewPermission(): bool
    {
        return strpos($this->name, 'view_') === 0;
    }

    /**
     * Verificar se é permissão de criação
     */
    public function isCreatePermission(): bool
    {
        return strpos($this->name, 'create_') === 0;
    }

    /**
     * Verificar se é permissão de edição
     */
    public function isEditPermission(): bool
    {
        return strpos($this->name, 'edit_') === 0 || strpos($this->name, 'update_') === 0;
    }

    /**
     * Verificar se é permissão de exclusão
     */
    public function isDeletePermission(): bool
    {
        return strpos($this->name, 'delete_') === 0 || strpos($this->name, 'destroy_') === 0;
    }

    /**
     * Obter ícone para a permissão
     */
    public function getIconAttribute(): string
    {
        $icons = [
            'view_dashboard' => 'fas fa-tachometer-alt',
            'create_users' => 'fas fa-user-plus',
            'edit_users' => 'fas fa-user-edit',
            'delete_users' => 'fas fa-user-minus',
            'view_logs' => 'fas fa-list-alt',
            'manage_permissions' => 'fas fa-shield-alt',
        ];

        return $icons[$this->name] ?? 'fas fa-key';
    }

    /**
     * Obter cor para a permissão
     */
    public function getColorAttribute(): string
    {
        $colors = [
            'view_dashboard' => 'blue',
            'create_users' => 'green',
            'edit_users' => 'yellow',
            'delete_users' => 'red',
            'view_logs' => 'purple',
            'manage_permissions' => 'indigo',
        ];

        return $colors[$this->name] ?? 'gray';
    }
}
