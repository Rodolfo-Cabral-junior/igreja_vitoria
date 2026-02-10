<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Administrativo</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    @if(session('user'))
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <img src="/images/logos/logo-principal.svg" alt="Igreja VITÓRIA" class="h-8 w-auto">
                    <h1 class="text-xl font-bold">Dashboard Admin</h1>
                    <span class="text-sm">Bem-vindo, {{ session('user')->name }}</span>
                </div>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('admin.dashboard.complete') }}" class="bg-purple-600 hover:bg-purple-700 px-4 py-2 rounded text-sm transition">
                        <i class="fas fa-th-large mr-2"></i>Painel Completo
                    </a>
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
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-6">
                {{ session('error') }}
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-2xl font-bold text-gray-800">Gerenciamento de Usuários</h2>
                <a href="{{ route('admin.users.create') }}" 
                   class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition">
                    + Novo Usuário
                </a>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full table-auto">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-gray-700">ID</th>
                            <th class="px-4 py-2 text-left text-gray-700">Nome</th>
                            <th class="px-4 py-2 text-left text-gray-700">Email</th>
                            <th class="px-4 py-2 text-left text-gray-700">Username</th>
                            <th class="px-4 py-2 text-left text-gray-700">Função</th>
                            <th class="px-4 py-2 text-left text-gray-700">Criado em</th>
                            <th class="px-4 py-2 text-left text-gray-700">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="px-4 py-2">{{ $user->id }}</td>
                            <td class="px-4 py-2 font-medium">{{ $user->name }}</td>
                            <td class="px-4 py-2">{{ $user->email }}</td>
                            <td class="px-4 py-2">{{ $user->username }}</td>
                            <td class="px-4 py-2">
                                <span class="{{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : 'bg-gray-100 text-gray-800' }} 
                                           px-2 py-1 rounded-full text-xs">
                                    {{ $user->role === 'admin' ? 'Admin' : 'Usuário' }}
                                </span>
                            </td>
                            <td class="px-4 py-2 text-sm text-gray-600">
                                {{ $user->created_at->format('d/m/Y H:i') }}
                            </td>
                            <td class="px-4 py-2">
                                <div class="flex space-x-2">
                                    <a href="{{ route('admin.users.show', $user->id) }}" 
                                       class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm transition">
                                        Ver
                                    </a>
                                    <a href="{{ route('admin.users.edit', $user->id) }}" 
                                       class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded text-sm transition">
                                        Editar
                                    </a>
                                    @if(session('user')->id !== $user->id)
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" 
                                              onsubmit="return confirm('Tem certeza que deseja excluir este usuário?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition">
                                                Excluir
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            @if(empty($users))
                <div class="text-center py-8 text-gray-500">
                    Nenhum usuário encontrado.
                </div>
            @endif
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Total de Usuários</h3>
                <p class="text-3xl font-bold text-blue-600">{{ count($users) }}</p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Administradores</h3>
                <p class="text-3xl font-bold text-purple-600">
                    {{ $users->where('role', 'admin')->count() }}
                </p>
            </div>
            <div class="bg-white rounded-lg shadow-md p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Usuários Comuns</h3>
                <p class="text-3xl font-bold text-gray-600">
                    {{ $users->where('role', 'user')->count() }}
                </p>
            </div>
        </div>
    </div>
    @else
    <div class="min-h-screen flex items-center justify-center bg-gray-100">
        <div class="bg-white p-8 rounded-lg shadow-md">
            <p class="text-gray-600">Você precisa estar logado para acessar esta página.</p>
            <a href="{{ route('login') }}" class="mt-4 inline-block bg-blue-500 text-white px-4 py-2 rounded">
                Fazer Login
            </a>
        </div>
    </div>
    @endif
</body>
</html>
