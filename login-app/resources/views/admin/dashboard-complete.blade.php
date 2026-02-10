<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo Completo</title>
    <link rel="icon" type="image/svg+xml" href="/images/icons/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.12);
        }
        .stat-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .log-entry {
            transition: all 0.2s ease;
        }
        .log-entry:hover {
            background-color: #f8f9fa;
            transform: translateX(2px);
        }
        .activity-item {
            border-left: 3px solid #667eea;
        }
        .scroll-container {
            max-height: 400px;
            overflow-y: auto;
        }
        .scroll-container::-webkit-scrollbar {
            width: 6px;
        }
        .scroll-container::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        .scroll-container::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 3px;
        }
    </style>
</head>
<body class="bg-gray-50">
    @if(session('user'))
    <nav class="gradient-bg shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <img src="/images/logos/logo-principal.svg" alt="Igreja VITÓRIA" class="h-8 w-auto">
                    <h1 class="text-white text-xl font-bold">Painel Administrativo</h1>
                    <span class="bg-red-600 text-white px-2 py-1 rounded-full text-xs">SUPER ADMIN</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="text-white text-sm">
                        <i class="fas fa-user-shield mr-2"></i>
                        {{ session('user')->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <!-- Estatísticas Principais -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="stat-card text-white rounded-xl p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Usuários Totais</p>
                        <p class="text-3xl font-bold">247</p>
                        <p class="text-white/70 text-xs mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>+12 este mês
                        </p>
                    </div>
                    <i class="fas fa-users text-4xl text-white/50"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-xl p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Pedidos de Oração</p>
                        <p class="text-3xl font-bold">1,842</p>
                        <p class="text-white/70 text-xs mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>+234 esta semana
                        </p>
                    </div>
                    <i class="fas fa-praying-hands text-4xl text-white/50"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-xl p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Doações</p>
                        <p class="text-3xl font-bold">R$ 45.678</p>
                        <p class="text-white/70 text-xs mt-1">
                            <i class="fas fa-arrow-up mr-1"></i>R$ 8.234 este mês
                        </p>
                    </div>
                    <i class="fas fa-hand-holding-heart text-4xl text-white/50"></i>
                </div>
            </div>

            <div class="bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-xl p-6 card-hover">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-white/80 text-sm">Eventos</p>
                        <p class="text-3xl font-bold">28</p>
                        <p class="text-white/70 text-xs mt-1">
                            <i class="fas fa-calendar mr-1"></i>5 este mês
                        </p>
                    </div>
                    <i class="fas fa-calendar-alt text-4xl text-white/50"></i>
                </div>
            </div>
        </div>

        <!-- Controles do Sistema -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
            <!-- Gerenciamento de Usuários -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-users-cog text-blue-600 mr-2"></i>
                    Gerenciamento de Usuários
                </h3>
                <div class="space-y-3">
                    <a href="{{ route('admin.users.index') }}" class="block bg-blue-50 hover:bg-blue-100 p-3 rounded-lg transition">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Todos os Usuários</span>
                            <span class="bg-blue-600 text-white px-2 py-1 rounded text-xs">247</span>
                        </div>
                    </a>
                    <a href="{{ route('admin.users.create') }}" class="block bg-green-50 hover:bg-green-100 p-3 rounded-lg transition">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Novo Usuário</span>
                            <i class="fas fa-plus text-green-600"></i>
                        </div>
                    </a>
                    <button class="w-full bg-yellow-50 hover:bg-yellow-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Usuários Inativos</span>
                            <span class="bg-yellow-600 text-white px-2 py-1 rounded text-xs">12</span>
                        </div>
                    </button>
                    <button class="w-full bg-red-50 hover:bg-red-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Usuários Bloqueados</span>
                            <span class="bg-red-600 text-white px-2 py-1 rounded text-xs">3</span>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Logs do Sistema -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-history text-purple-600 mr-2"></i>
                    Logs do Sistema
                </h3>
                <div class="space-y-3">
                    <button class="w-full bg-purple-50 hover:bg-purple-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Logs de Acesso</span>
                            <i class="fas fa-sign-in-alt text-purple-600"></i>
                        </div>
                    </button>
                    <button class="w-full bg-indigo-50 hover:bg-indigo-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Logs de Alterações</span>
                            <i class="fas fa-edit text-indigo-600"></i>
                        </div>
                    </button>
                    <button class="w-full bg-pink-50 hover:bg-pink-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Logs de Erros</span>
                            <span class="bg-pink-600 text-white px-2 py-1 rounded text-xs">5</span>
                        </div>
                    </button>
                    <button class="w-full bg-gray-50 hover:bg-gray-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Exportar Logs</span>
                            <i class="fas fa-download text-gray-600"></i>
                        </div>
                    </button>
                </div>
            </div>

            <!-- Configurações -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-cogs text-gray-600 mr-2"></i>
                    Configurações
                </h3>
                <div class="space-y-3">
                    <button class="w-full bg-gray-50 hover:bg-gray-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Configurações Gerais</span>
                            <i class="fas fa-sliders-h text-gray-600"></i>
                        </div>
                    </button>
                    <button class="w-full bg-blue-50 hover:bg-blue-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Segurança</span>
                            <i class="fas fa-shield-alt text-blue-600"></i>
                        </div>
                    </button>
                    <button class="w-full bg-green-50 hover:bg-green-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Backup</span>
                            <i class="fas fa-database text-green-600"></i>
                        </div>
                    </button>
                    <button class="w-full bg-orange-50 hover:bg-orange-100 p-3 rounded-lg transition text-left">
                        <div class="flex items-center justify-between">
                            <span class="text-sm font-medium">Manutenção</span>
                            <i class="fas fa-tools text-orange-600"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>

        <!-- Atividades Recentes e Dados Inseridos -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Atividades Recentes -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-clock text-orange-600 mr-2"></i>
                        Atividades Recentes
                    </h3>
                    <button class="text-orange-600 hover:text-orange-800 text-sm">
                        Ver todos →
                    </button>
                </div>
                <div class="scroll-container space-y-3">
                    <div class="activity-item pl-4 py-3 log-entry">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Novo usuário criado</p>
                                <p class="text-xs text-gray-600">Maria Santos - maria.santos@email.com</p>
                                <p class="text-xs text-gray-500">Há 2 minutos</p>
                            </div>
                            <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Usuário</span>
                        </div>
                    </div>
                    <div class="activity-item pl-4 py-3 log-entry">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Pedido de oração recebido</p>
                                <p class="text-xs text-gray-600">Cura para enfermidade - João Silva</p>
                                <p class="text-xs text-gray-500">Há 15 minutos</p>
                            </div>
                            <span class="bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs">Oração</span>
                        </div>
                    </div>
                    <div class="activity-item pl-4 py-3 log-entry">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Doação processada</p>
                                <p class="text-xs text-gray-600">R$ 150,00 - Dízimo</p>
                                <p class="text-xs text-gray-500">Há 1 hora</p>
                            </div>
                            <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Doação</span>
                        </div>
                    </div>
                    <div class="activity-item pl-4 py-3 log-entry">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Evento criado</p>
                                <p class="text-xs text-gray-600">Culto de Celebração - 15/02</p>
                                <p class="text-xs text-gray-500">Há 2 horas</p>
                            </div>
                            <span class="bg-orange-100 text-orange-800 px-2 py-1 rounded text-xs">Evento</span>
                        </div>
                    </div>
                    <div class="activity-item pl-4 py-3 log-entry">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Usuário atualizado</p>
                                <p class="text-xs text-gray-600">Pedro Costa - Alteração de email</p>
                                <p class="text-xs text-gray-500">Há 3 horas</p>
                            </div>
                            <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs">Update</span>
                        </div>
                    </div>
                    <div class="activity-item pl-4 py-3 log-entry">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Login no sistema</p>
                                <p class="text-xs text-gray-600">Ana Maria - IP 192.168.1.100</p>
                                <p class="text-xs text-gray-500">Há 4 horas</p>
                            </div>
                            <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded text-xs">Acesso</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dados Inseridos por Usuário -->
            <div class="bg-white rounded-xl shadow-md p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-bold text-gray-800">
                        <i class="fas fa-database text-green-600 mr-2"></i>
                        Dados Inseridos por Usuário
                    </h3>
                    <button class="text-green-600 hover:text-green-800 text-sm">
                        Filtrar →
                    </button>
                </div>
                <div class="scroll-container space-y-3">
                    <div class="border rounded-lg p-3 hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Maria Santos</p>
                                <p class="text-xs text-gray-600">maria.santos@email.com</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs bg-green-50 p-1 rounded">✓ Pedido de oração: "Cura familiar"</p>
                                    <p class="text-xs bg-blue-50 p-1 rounded">✓ Doação: R$ 200,00</p>
                                    <p class="text-xs bg-purple-50 p-1 rounded">✓ Inscrição: Seminário Teologia</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">Hoje, 14:30</span>
                        </div>
                    </div>
                    <div class="border rounded-lg p-3 hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">João Silva</p>
                                <p class="text-xs text-gray-600">joao.silva@email.com</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs bg-green-50 p-1 rounded">✓ Pedido de oração: "Emprego"</p>
                                    <p class="text-xs bg-orange-50 p-1 rounded">✓ Evento: Confirmado presença</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">Hoje, 12:15</span>
                        </div>
                    </div>
                    <div class="border rounded-lg p-3 hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Ana Maria</p>
                                <p class="text-xs text-gray-600">ana.maria@email.com</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs bg-green-50 p-1 rounded">✓ Pedido de oração: "Saúde"</p>
                                    <p class="text-xs bg-blue-50 p-1 rounded">✓ Doação: R$ 100,00</p>
                                    <p class="text-xs bg-green-50 p-1 rounded">✓ Pedido de oração: "Filhos"</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">Ontem, 18:45</span>
                        </div>
                    </div>
                    <div class="border rounded-lg p-3 hover:shadow-md transition">
                        <div class="flex items-start justify-between">
                            <div>
                                <p class="text-sm font-medium">Pedro Costa</p>
                                <p class="text-xs text-gray-600">pedro.costa@email.com</p>
                                <div class="mt-2 space-y-1">
                                    <p class="text-xs bg-purple-50 p-1 rounded">✓ Inscrição: 3 seminários</p>
                                    <p class="text-xs bg-blue-50 p-1 rounded">✓ Doação recorrente: R$ 50/mês</p>
                                </div>
                            </div>
                            <span class="text-xs text-gray-500">Ontem, 16:20</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Calendário de Atividades -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">
                    <i class="fas fa-calendar-alt text-indigo-600 mr-2"></i>
                    Calendário de Atividades
                </h3>
                <div class="flex space-x-2">
                    <button class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-sm hover:bg-indigo-200">
                        <i class="fas fa-chevron-left mr-1"></i>Anterior
                    </button>
                    <span class="bg-indigo-600 text-white px-3 py-1 rounded text-sm">Fevereiro 2026</span>
                    <button class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded text-sm hover:bg-indigo-200">
                        Próximo<i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>
            </div>
            <div class="grid grid-cols-7 gap-2 text-center">
                <div class="font-bold text-sm text-gray-600 p-2">Dom</div>
                <div class="font-bold text-sm text-gray-600 p-2">Seg</div>
                <div class="font-bold text-sm text-gray-600 p-2">Ter</div>
                <div class="font-bold text-sm text-gray-600 p-2">Qua</div>
                <div class="font-bold text-sm text-gray-600 p-2">Qui</div>
                <div class="font-bold text-sm text-gray-600 p-2">Sex</div>
                <div class="font-bold text-sm text-gray-600 p-2">Sáb</div>
                
                <!-- Dias do mês -->
                @for($day = 1; $day <= 28; $day++)
                    <div class="border rounded p-2 hover:bg-gray-50 cursor-pointer text-sm">
                        {{ $day }}
                        @if($day == 15)
                            <div class="w-2 h-2 bg-red-500 rounded-full mx-auto mt-1"></div>
                        @elseif($day == 18)
                            <div class="w-2 h-2 bg-blue-500 rounded-full mx-auto mt-1"></div>
                        @elseif($day == 22)
                            <div class="w-2 h-2 bg-green-500 rounded-full mx-auto mt-1"></div>
                        @endif
                    </div>
                @endfor
            </div>
            <div class="mt-4 flex items-center space-x-4 text-sm">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-red-500 rounded-full mr-2"></div>
                    <span>Culto</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-500 rounded-full mr-2"></div>
                    <span>Estudo Bíblico</span>
                </div>
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                    <span>Grupo de Oração</span>
                </div>
            </div>
        </div>

        <!-- Status do Sistema -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-server text-blue-600 mr-2"></i>
                    Status do Servidor
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm">CPU</span>
                        <div class="flex items-center">
                            <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-green-500 h-2 rounded-full" style="width: 35%"></div>
                            </div>
                            <span class="text-sm text-green-600">35%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Memória</span>
                        <div class="flex items-center">
                            <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-yellow-500 h-2 rounded-full" style="width: 68%"></div>
                            </div>
                            <span class="text-sm text-yellow-600">68%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Disco</span>
                        <div class="flex items-center">
                            <div class="w-24 bg-gray-200 rounded-full h-2 mr-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 42%"></div>
                            </div>
                            <span class="text-sm text-blue-600">42%</span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Uptime</span>
                        <span class="text-sm text-green-600">99.9%</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-shield-alt text-green-600 mr-2"></i>
                    Segurança
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Firewall</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Ativo</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">SSL Cert</span>
                        <span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs">Válido</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Backup</span>
                        <span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs">Diário</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Última Scan</span>
                        <span class="text-sm text-gray-600">2h atrás</span>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-tachometer-alt text-purple-600 mr-2"></i>
                    Performance
                </h3>
                <div class="space-y-3">
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Tempo Resposta</span>
                        <span class="text-sm text-green-600">245ms</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Req/Seg</span>
                        <span class="text-sm text-blue-600">1,247</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Users Online</span>
                        <span class="text-sm text-purple-600">89</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm">Cache Hit</span>
                        <span class="text-sm text-green-600">94.2%</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
</body>
</html>
