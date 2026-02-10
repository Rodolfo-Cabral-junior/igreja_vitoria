<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'description',
        'ip_address',
        'user_agent'
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    /**
     * Relacionamento com User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Escopo para ações recentes
     */
    public function scopeRecent($query, int $hours = 24)
    {
        return $query->where('created_at', '>=', now()->subHours($hours));
    }

    /**
     * Escopo para ações específicas
     */
    public function scopeAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    /**
     * Obter descrição formatada da ação
     */
    public function getFormattedActionAttribute(): string
    {
        $actions = [
            'login' => 'Login no sistema',
            'logout' => 'Logout do sistema',
            'user_created' => 'Usuário criado',
            'user_updated' => 'Usuário atualizado',
            'user_deleted' => 'Usuário excluído',
            'profile_updated' => 'Perfil atualizado',
            'permission_changed' => 'Permissão alterada',
        ];

        return $actions[$this->action] ?? $this->action;
    }

    /**
     * Obter IP formatado
     */
    public function getFormattedIpAttribute(): string
    {
        return $this->ip_address ?? 'Desconhecido';
    }

    /**
     * Obter user agent resumido
     */
    public function getShortUserAgentAttribute(): string
    {
        if (!$this->user_agent) return 'Desconhecido';
        
        // Extrair informações principais do user agent
        if (strpos($this->user_agent, 'Chrome') !== false) {
            return 'Chrome';
        } elseif (strpos($this->user_agent, 'Firefox') !== false) {
            return 'Firefox';
        } elseif (strpos($this->user_agent, 'Safari') !== false) {
            return 'Safari';
        }
        
        return 'Outro';
    }
}
