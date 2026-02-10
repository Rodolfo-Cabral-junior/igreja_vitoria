<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Usuário</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <h1 class="text-xl font-bold">Dashboard Admin</h1>
                    <span class="text-sm">Bem-vindo, {{ session('user')->name }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="bg-blue-800 px-3 py-1 rounded-full text-xs">
                        {{ session('user')->role === 'admin' ? 'Administrador' : 'Usuário' }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-red-500 hover:bg-red-600 px-4 py-2 rounded text-sm transition">
                            Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-4 py-8">
        <div class="max-w-4xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="text-blue-600 hover:text-blue-800 mr-4">
                            ← Voltar
                        </a>
                        <h2 class="text-2xl font-bold text-gray-800">Detalhes do Usuário</h2>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                           class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded transition">
                            Editar
                        </a>
                        @if(session('user')->id !== $user->id)
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                  onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">
                                    Excluir
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações Pessoais</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">ID:</span>
                                    <span class="font-medium">{{ $user->id }}</span>
                                </div>
                                
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Nome Completo:</span>
                                    <span class="font-medium">{{ $user->name }}</span>
                                </div>
                                
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Username:</span>
                                    <span class="font-medium">{{ $user->username }}</span>
                                </div>
                                
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-medium">{{ $user->email }}</span>
                                </div>
                                
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Função:</span>
                                    <span class="{{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }} 
                                               px-2 py-1 rounded-full text-xs">
                                        {{ $user->role === 'admin' ? 'Administrador' : 'Usuário Comum' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-800 mb-4">Informações do Sistema</h3>
                            
                            <div class="space-y-3">
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Data de Criação:</span>
                                    <span class="font-medium">{{ $user->created_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                                
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Última Atualização:</span>
                                    <span class="font-medium">{{ $user->updated_at->format('d/m/Y H:i:s') }}</span>
                                </div>
                                
                                <div class="flex justify-between py-2 border-b">
                                    <span class="text-gray-600">Email Verificado:</span>
                                    <span class="{{ $user->email_verified_at ? 'text-green-600' : 'text-red-600' }} font-medium">
                                        {{ $user->email_verified_at ? 'Sim' : 'Não' }}
                                    </span>
                                </div>
                                
                                @if($user->email_verified_at)
                                    <div class="flex justify-between py-2 border-b">
                                        <span class="text-gray-600">Data Verificação:</span>
                                        <span class="font-medium">{{ $user->email_verified_at->format('d/m/Y H:i') }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8 p-4 bg-blue-50 rounded-md">
                    <h4 class="text-lg font-semibold text-blue-800 mb-2">Resumo da Conta</h4>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-center">
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ $user->id }}</p>
                            <p class="text-sm text-gray-600">ID do Usuário</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-blue-600">{{ $user->role }}</p>
                            <p class="text-sm text-gray-600">Tipo de Conta</p>
                        </div>
                        <div>
                            <p class="text-2xl font-bold text-blue-600">
                                {{ $user->created_at->diffInDays(now()) }} dias
                            </p>
                            <p class="text-sm text-gray-600">Tempo de Cadastro</p>
                        </div>
                    </div>
                </div>

                @if(session('user')->id === $user->id)
                    <div class="mt-6 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                        <p class="text-yellow-800 text-sm">
                            <strong>Atenção:</strong> Você está visualizando sua própria conta. 
                            Algumas ações podem estar limitadas para proteger sua conta.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>
