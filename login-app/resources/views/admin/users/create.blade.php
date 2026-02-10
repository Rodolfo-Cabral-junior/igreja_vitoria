<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Novo Usuário</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-blue-600 text-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <img src="/images/logos/logo-principal.svg" alt="Igreja VITÓRIA" class="h-8 w-auto">
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
        <div class="max-w-2xl mx-auto">
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex items-center mb-6">
                    <a href="{{ route('admin.dashboard') }}" 
                       class="text-blue-600 hover:text-blue-800 mr-4">
                        ← Voltar
                    </a>
                    <h2 class="text-2xl font-bold text-gray-800">Criar Novo Usuário</h2>
                </div>

                <form action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-gray-700 font-medium mb-2">
                                Nome Completo *
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   required
                                   placeholder="Digite o nome completo"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('name') }}"
                                   onkeyup="gerarSugestoes()">
                            @error('name')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="username" class="block text-gray-700 font-medium mb-2">
                                Username *
                            </label>
                            <input type="text" 
                                   id="username" 
                                   name="username" 
                                   required
                                   placeholder="Será gerado automaticamente"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('username') }}"
                                   readonly>
                            @error('username')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="email" class="block text-gray-700 font-medium mb-2">
                                Email *
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   required
                                   placeholder="exemplo@dominio.com"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   value="{{ old('email') }}"
                                   onkeyup="gerarSugestoes()">
                            @error('email')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="role" class="block text-gray-700 font-medium mb-2">
                                Função *
                            </label>
                            <select id="role" 
                                    name="role" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Selecione uma função</option>
                                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>
                                    Usuário Comum
                                </option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>
                                    Administrador
                                </option>
                            </select>
                            @error('role')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password" class="block text-gray-700 font-medium mb-2">
                                Senha *
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   required
                                   minlength="6"
                                   placeholder="Mínimo 6 caracteres"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
                                   onkeyup="gerarSenhaSugerida()">
                            @error('password')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="block text-gray-700 font-medium mb-2">
                                Confirmar Senha *
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required
                                   minlength="6"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('password_confirmation')
                                <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="flex justify-end space-x-4 mt-8">
                        <a href="{{ route('admin.dashboard') }}" 
                           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-6 py-2 rounded transition">
                            Cancelar
                        </a>
                        <button type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-6 py-2 rounded transition">
                            Criar Usuário
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function gerarSugestoes() {
            const nome = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            
            // Gerar username a partir do nome
            if (nome) {
                const nomes = nome.trim().split(' ');
                let username = '';
                
                if (nomes.length >= 2) {
                    // Pega primeira letra do primeiro nome + sobrenome completo
                    username = nomes[0].charAt(0) + nomes[nomes.length - 1];
                } else {
                    username = nomes[0];
                }
                
                // Remover caracteres especiais e converter para maiúsculas
                username = username.replace(/[^a-zA-Z0-9]/g, '').toUpperCase();
                document.getElementById('username').value = username;
            }
            
            // Gerar sugestão de email se não tiver @
            if (nome && !email.includes('@')) {
                const nomeLimpo = nome.trim().toLowerCase().replace(/\s+/g, '.');
                const dominiosSugeridos = ['@gmail.com', '@outlook.com', '@yahoo.com', '@hotmail.com'];
                
                // Se já começou a digitar, completar com sugestões
                if (email.length > 0 && !email.includes('@')) {
                    const sugestoesDiv = document.getElementById('email-sugestoes');
                    if (!sugestoesDiv) {
                        const div = document.createElement('div');
                        div.id = 'email-sugestoes';
                        div.className = 'absolute bg-white border border-gray-300 rounded-md shadow-lg z-10 mt-1';
                        div.style.width = document.getElementById('email').offsetWidth + 'px';
                        document.getElementById('email').parentNode.appendChild(div);
                    }
                    
                    let sugestoesHTML = '';
                    dominiosSugeridos.forEach(dominio => {
                        sugestoesHTML += `<div class="px-3 py-2 hover:bg-gray-100 cursor-pointer" onclick="selecionarEmail('${nomeLimpo}${dominio}')">${nomeLimpo}${dominio}</div>`;
                    });
                    
                    document.getElementById('email-sugestoes').innerHTML = sugestoesHTML;
                } else {
                    // Limpar sugestões se tiver @ ou estiver vazio
                    const sugestoesDiv = document.getElementById('email-sugestoes');
                    if (sugestoesDiv) sugestoesDiv.remove();
                }
            }
        }
        
        function selecionarEmail(emailCompleto) {
            document.getElementById('email').value = emailCompleto;
            const sugestoesDiv = document.getElementById('email-sugestoes');
            if (sugestoesDiv) sugestoesDiv.remove();
        }
        
        function gerarSenhaSugerida() {
            const senha = document.getElementById('password').value;
            const nome = document.getElementById('name').value;
            
            // Se a senha estiver vazia, gerar sugestão baseada no nome
            if (!senha && nome) {
                const nomes = nome.trim().split(' ');
                let senhaSugerida = '';
                
                if (nomes.length >= 2) {
                    // Primeiras letras + ano atual
                    senhaSugerida = nomes[0].substring(0, 3).toUpperCase() + 
                                   nomes[nomes.length - 1].substring(0, 3).toUpperCase() + 
                                   new Date().getFullYear().toString().slice(-2);
                } else {
                    senhaSugerida = nomes[0].substring(0, 6).toUpperCase() + '2024';
                }
                
                // Adicionar sugestão visual
                let sugestaoDiv = document.getElementById('senha-sugestao');
                if (!sugestaoDiv) {
                    sugestaoDiv = document.createElement('div');
                    sugestaoDiv.id = 'senha-sugestao';
                    sugestaoDiv.className = 'text-sm text-blue-600 mt-1 cursor-pointer hover:text-blue-800';
                    sugestaoDiv.onclick = function() {
                        document.getElementById('password').value = senhaSugerida;
                        document.getElementById('password_confirmation').value = senhaSugerida;
                        this.remove();
                    };
                    document.getElementById('password').parentNode.appendChild(sugestaoDiv);
                }
                sugestaoDiv.textContent = `💡 Sugerido: ${senhaSugerida} (clique para usar)`;
            } else {
                // Remover sugestão se o usuário começou a digitar
                const sugestaoDiv = document.getElementById('senha-sugestao');
                if (sugestaoDiv && senha) sugestaoDiv.remove();
            }
        }
        
        // Fechar sugestões de email ao clicar fora
        document.addEventListener('click', function(event) {
            if (!event.target.closest('#email') && !event.target.closest('#email-sugestoes')) {
                const sugestoesDiv = document.getElementById('email-sugestoes');
                if (sugestoesDiv) sugestoesDiv.remove();
            }
        });
        
        // Adicionar estilo para posicionamento relativo
        document.getElementById('email').parentNode.style.position = 'relative';
    </script>
</body>
</html>
