<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Membro</title>
    <link rel="icon" type="image/svg+xml" href="/images/icons/favicon.svg">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-hover {
            transition: all 0.3s ease;
        }
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .prayer-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }
        .donation-card {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
        }
        .seminar-card {
            background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
        }
        .calendar-card {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
        }
        .main-background {
            background-image: url('{{ asset("images/banners/686_pil.jpg") }}');
            background-size: cover;
            background-position: center center;
            background-attachment: fixed;
            background-repeat: no-repeat;
            min-height: 100vh;
            position: relative;
            background-color: #f8f9fa;
        }
        
        @media (max-width: 1024px) {
            .main-background {
                background-size: cover;
                background-position: center center;
                background-attachment: scroll;
            }
        }
        
        @media (max-width: 768px) {
            .main-background {
                background-size: 100% auto;
                background-position: top center;
                background-attachment: scroll;
            }
        }
        
        @media (max-width: 640px) {
            .main-background {
                background-size: 130% auto;
                background-position: center center;
                background-attachment: scroll;
            }
        }
        
        @media (max-width: 480px) {
            .main-background {
                background-size: 150% auto;
                background-position: center 20%;
                background-attachment: scroll;
            }
        }
        
        @media (max-width: 320px) {
            .main-background {
                background-size: 180% auto;
                background-position: center 15%;
                background-attachment: scroll;
            }
        }
        
        @media (max-height: 600px) {
            .main-background {
                background-size: auto 100%;
                background-position: center center;
            }
        }
        
        @media (max-height: 400px) {
            .main-background {
                background-size: auto 120%;
                background-position: center center;
            }
        }
        
        .content-overlay {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            position: relative;
            z-index: 1;
        }
    </style>
</head>
<body class="main-background">
    <!-- Navbar -->
    <nav class="gradient-bg shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <img src="/images/logos/logo-principal.svg" alt="Igreja VITÓRIA" class="h-8 w-auto">
                    <h1 class="text-white text-xl font-bold">Igreja VITÓRIA</h1>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-white text-sm">
                        <i class="fas fa-user mr-2"></i>
                        {{ session('user')->name }}
                        <span class="bg-white/20 px-2 py-1 rounded-full text-xs ml-2">
                            Membro
                        </span>
                    </div>
                    <form action="{{ route('logout') }}" method="POST" class="inline">
                        @csrf
                        <button type="submit" class="bg-white/20 hover:bg-white/30 text-white px-4 py-2 rounded-lg text-sm transition">
                            <i class="fas fa-sign-out-alt mr-2"></i>Sair
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container mx-auto px-4 py-8">
        <!-- Welcome Section -->
        <div class="content-overlay rounded-xl shadow-md p-6 mb-8">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">
                        Bem-vindo(a), {{ session('user')->name }}! 👋
                    </h2>
                    <p class="text-gray-600">
                        <i class="fas fa-calendar-alt mr-2"></i>
                        {{ now()->format('d/m/Y') }} - {{ now()->format('l') }}
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-4xl font-bold text-purple-600" id="currentTime">00:00</div>
                    <div class="text-sm text-gray-500">Horário de Oração</div>
                </div>
            </div>
        </div>

        <!-- Main Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Pedido de Oração -->
            <div class="card-hover prayer-card rounded-xl p-6 text-white cursor-pointer" onclick="openPrayerModal()">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-praying-hands text-3xl"></i>
                    <span class="bg-white/20 px-2 py-1 rounded-full text-xs">Novo</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Pedido de Oração</h3>
                <p class="text-sm opacity-90">Envie seu pedido de oração</p>
                <div class="mt-4 text-xs opacity-75">
                    <i class="fas fa-users mr-1"></i>
                    <span id="prayerCount">127</span> orações esta semana
                </div>
            </div>

            <!-- Doações -->
            <div class="card-hover donation-card rounded-xl p-6 text-white cursor-pointer" onclick="openDonationModal()">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-hand-holding-heart text-3xl"></i>
                    <span class="bg-white/20 px-2 py-1 rounded-full text-xs">Oferta</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Doações</h3>
                <p class="text-sm opacity-90">Contribua com a obra</p>
                <div class="mt-4 text-xs opacity-75">
                    <i class="fas fa-chart-line mr-1"></i>
                    Meta: R$ 5.000 este mês
                </div>
            </div>

            <!-- Seminários Teológicos -->
            <div class="card-hover seminar-card rounded-xl p-6 text-white cursor-pointer" onclick="openSeminarModal()">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-graduation-cap text-3xl"></i>
                    <span class="bg-white/20 px-2 py-1 rounded-full text-xs">Educação</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Seminários</h3>
                <p class="text-sm opacity-90">Aprofunde seu conhecimento</p>
                <div class="mt-4 text-xs opacity-75">
                    <i class="fas fa-book mr-1"></i>
                    <span id="seminarCount">3</span> cursos disponíveis
                </div>
            </div>

            <!-- Calendário -->
            <div class="card-hover calendar-card rounded-xl p-6 text-white cursor-pointer" onclick="openCalendarModal()">
                <div class="flex items-center justify-between mb-4">
                    <i class="fas fa-calendar-alt text-3xl"></i>
                    <span class="bg-white/20 px-2 py-1 rounded-full text-xs">Eventos</span>
                </div>
                <h3 class="text-xl font-bold mb-2">Calendário</h3>
                <p class="text-sm opacity-90">Eventos e atividades</p>
                <div class="mt-4 text-xs opacity-75">
                    <i class="fas fa-clock mr-1"></i>
                    <span id="eventCount">5</span> eventos este mês
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Últimos Pedidos de Oração -->
            <div class="content-overlay rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-praying-hands text-purple-600 mr-2"></i>
                    Pedidos de Oração Recentes
                </h3>
                <div class="space-y-3" id="recentPrayers">
                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <p class="text-sm font-medium">Cura para enfermidade</p>
                        <p class="text-xs text-gray-500">Maria Silva - 2h atrás</p>
                    </div>
                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <p class="text-sm font-medium">Restauração familiar</p>
                        <p class="text-xs text-gray-500">João Santos - 5h atrás</p>
                    </div>
                    <div class="border-l-4 border-purple-500 pl-4 py-2">
                        <p class="text-sm font-medium">Emprego e provisão</p>
                        <p class="text-xs text-gray-500">Pedro Costa - 1d atrás</p>
                    </div>
                </div>
                <button class="mt-4 text-purple-600 text-sm hover:text-purple-800 font-medium">
                    Ver todos →
                </button>
            </div>

            <!-- Próximos Eventos -->
            <div class="content-overlay rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-calendar text-orange-600 mr-2"></i>
                    Próximos Eventos
                </h3>
                <div class="space-y-3" id="upcomingEvents">
                    <div class="flex items-center space-x-3">
                        <div class="bg-orange-100 text-orange-600 rounded-lg p-2 text-center min-w-[50px]">
                            <div class="text-xs">FEV</div>
                            <div class="text-lg font-bold">15</div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Culto de Celebração</p>
                            <p class="text-xs text-gray-500">19:00 - Templo Principal</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-orange-100 text-orange-600 rounded-lg p-2 text-center min-w-[50px]">
                            <div class="text-xs">FEV</div>
                            <div class="text-lg font-bold">18</div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Estudo Bíblico</p>
                            <p class="text-xs text-gray-500">20:00 - Salão de Eventos</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="bg-orange-100 text-orange-600 rounded-lg p-2 text-center min-w-[50px]">
                            <div class="text-xs">FEV</div>
                            <div class="text-lg font-bold">22</div>
                        </div>
                        <div>
                            <p class="text-sm font-medium">Grupo de Oração</p>
                            <p class="text-xs text-gray-500">18:00 - Sala de Oração</p>
                        </div>
                    </div>
                </div>
                <button class="mt-4 text-orange-600 text-sm hover:text-orange-800 font-medium">
                    Ver calendário completo →
                </button>
            </div>

            <!-- Seminários Disponíveis -->
            <div class="content-overlay rounded-xl shadow-md p-6">
                <h3 class="text-lg font-bold text-gray-800 mb-4">
                    <i class="fas fa-graduation-cap text-green-600 mr-2"></i>
                    Seminários em Destaque
                </h3>
                <div class="space-y-3" id="featuredSeminars">
                    <div class="border rounded-lg p-3 hover:shadow-md transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium">Teologia Sistemática I</p>
                                <p class="text-xs text-gray-500">Prof. Dr. Carlos Silva</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs bg-green-100 text-green-800 px-2 py-1 rounded">Iniciante</span>
                                    <span class="text-xs text-gray-500 ml-2">8 semanas</span>
                                </div>
                            </div>
                            <i class="fas fa-book-open text-green-600"></i>
                        </div>
                    </div>
                    <div class="border rounded-lg p-3 hover:shadow-md transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium">Hermenêutica Bíblica</p>
                                <p class="text-xs text-gray-500">Prof. Maria Santos</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Intermediário</span>
                                    <span class="text-xs text-gray-500 ml-2">6 semanas</span>
                                </div>
                            </div>
                            <i class="fas fa-book-open text-green-600"></i>
                        </div>
                    </div>
                    <div class="border rounded-lg p-3 hover:shadow-md transition cursor-pointer">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-sm font-medium">Cristologia</p>
                                <p class="text-xs text-gray-500">Prof. João Oliveira</p>
                                <div class="flex items-center mt-1">
                                    <span class="text-xs bg-red-100 text-red-800 px-2 py-1 rounded">Avançado</span>
                                    <span class="text-xs text-gray-500 ml-2">10 semanas</span>
                                </div>
                            </div>
                            <i class="fas fa-book-open text-green-600"></i>
                        </div>
                    </div>
                </div>
                <button class="mt-4 text-green-600 text-sm hover:text-green-800 font-medium">
                    Ver todos os cursos →
                </button>
            </div>
        </div>
    </div>

    <!-- Modals -->
    <div id="prayerModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold mb-4">Pedido de Oração</h3>
            <form onsubmit="submitPrayer(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Seu nome</label>
                    <input type="text" class="w-full border rounded-lg px-3 py-2" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Pedido de oração</label>
                    <textarea class="w-full border rounded-lg px-3 py-2 h-32" required></textarea>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">É anônimo?</label>
                    <input type="checkbox" class="mr-2">
                    <span class="text-sm">Não mostrar meu nome</span>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('prayerModal')" class="px-4 py-2 border rounded-lg">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg">Enviar Oração</button>
                </div>
            </form>
        </div>
    </div>

    <div id="donationModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <h3 class="text-xl font-bold mb-4">Fazer Doação</h3>
            <form onsubmit="submitDonation(event)">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Tipo de doação</label>
                    <select class="w-full border rounded-lg px-3 py-2">
                        <option>Dízimo</option>
                        <option>Oferta</option>
                        <option>Missões</option>
                        <option>Construção</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Valor (R$)</label>
                    <input type="number" class="w-full border rounded-lg px-3 py-2" placeholder="0,00" step="0.01" required>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Forma de pagamento</label>
                    <select class="w-full border rounded-lg px-3 py-2">
                        <option>Cartão de Crédito</option>
                        <option>Cartão de Débito</option>
                        <option>Pix</option>
                        <option>Boleto</option>
                    </select>
                </div>
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-2">Doação recorrente?</label>
                    <input type="checkbox" class="mr-2">
                    <span class="text-sm">Toda mês</span>
                </div>
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeModal('donationModal')" class="px-4 py-2 border rounded-lg">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg">Doar Agora</button>
                </div>
            </form>
        </div>
    </div>

    <div id="seminarModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 max-w-2xl w-full mx-4 max-h-[80vh] overflow-y-auto">
            <h3 class="text-xl font-bold mb-4">Seminários Teológicos Disponíveis</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                    <h4 class="font-bold mb-2">Teologia Sistemática I</h4>
                    <p class="text-sm text-gray-600 mb-2">Introdução à doutrina cristã e fundamentos teológicos.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">Iniciante</span>
                        <span class="text-sm font-bold">R$ 150,00</span>
                    </div>
                </div>
                <div class="border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                    <h4 class="font-bold mb-2">Hermenêutica Bíblica</h4>
                    <p class="text-sm text-gray-600 mb-2">Princípios de interpretação das Escrituras Sagradas.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm bg-yellow-100 text-yellow-800 px-2 py-1 rounded">Intermediário</span>
                        <span class="text-sm font-bold">R$ 200,00</span>
                    </div>
                </div>
                <div class="border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                    <h4 class="font-bold mb-2">Cristologia</h4>
                    <p class="text-sm text-gray-600 mb-2">Estudo aprofundado sobre a pessoa e obra de Jesus Cristo.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm bg-red-100 text-red-800 px-2 py-1 rounded">Avançado</span>
                        <span class="text-sm font-bold">R$ 250,00</span>
                    </div>
                </div>
                <div class="border rounded-lg p-4 hover:shadow-md transition cursor-pointer">
                    <h4 class="font-bold mb-2">História da Igreja</h4>
                    <p class="text-sm text-gray-600 mb-2">Desenvolvimento da igreja desde o pentecostes até os dias atuais.</p>
                    <div class="flex justify-between items-center">
                        <span class="text-sm bg-green-100 text-green-800 px-2 py-1 rounded">Iniciante</span>
                        <span class="text-sm font-bold">R$ 180,00</span>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeModal('seminarModal')" class="px-4 py-2 border rounded-lg">Fechar</button>
            </div>
        </div>
    </div>

    <div id="calendarModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-xl p-6 max-w-4xl w-full mx-4 max-h-[80vh] overflow-y-auto">
            <h3 class="text-xl font-bold mb-4">Calendário de Eventos</h3>
            <div class="grid grid-cols-1 md:grid-cols-7 gap-2 mb-4">
                <div class="text-center font-bold text-sm">Dom</div>
                <div class="text-center font-bold text-sm">Seg</div>
                <div class="text-center font-bold text-sm">Ter</div>
                <div class="text-center font-bold text-sm">Qua</div>
                <div class="text-center font-bold text-sm">Qui</div>
                <div class="text-center font-bold text-sm">Sex</div>
                <div class="text-center font-bold text-sm">Sáb</div>
            </div>
            <div class="grid grid-cols-7 gap-2" id="calendarDays">
                <!-- Calendar days will be generated by JavaScript -->
            </div>
            <div class="mt-6">
                <h4 class="font-bold mb-3">Eventos do Mês</h4>
                <div class="space-y-2">
                    <div class="flex items-center space-x-3 p-3 bg-purple-50 rounded-lg">
                        <div class="bg-purple-600 text-white rounded-lg p-2 text-center min-w-[50px]">
                            <div class="text-xs">FEV</div>
                            <div class="text-lg font-bold">15</div>
                        </div>
                        <div>
                            <p class="font-medium">Culto de Celebração</p>
                            <p class="text-sm text-gray-600">19:00 - Templo Principal</p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3 p-3 bg-blue-50 rounded-lg">
                        <div class="bg-blue-600 text-white rounded-lg p-2 text-center min-w-[50px]">
                            <div class="text-xs">FEV</div>
                            <div class="text-lg font-bold">18</div>
                        </div>
                        <div>
                            <p class="font-medium">Estudo Bíblico</p>
                            <p class="text-sm text-gray-600">20:00 - Salão de Eventos</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex justify-end mt-6">
                <button type="button" onclick="closeModal('calendarModal')" class="px-4 py-2 border rounded-lg">Fechar</button>
            </div>
        </div>
    </div>

    <script>
        // Update current time
        function updateTime() {
            const now = new Date();
            document.getElementById('currentTime').textContent = 
                now.toLocaleTimeString('pt-BR', { hour: '2-digit', minute: '2-digit' });
        }
        setInterval(updateTime, 1000);
        updateTime();

        // Modal functions
        function openPrayerModal() {
            document.getElementById('prayerModal').classList.remove('hidden');
        }

        function openDonationModal() {
            document.getElementById('donationModal').classList.remove('hidden');
        }

        function openSeminarModal() {
            document.getElementById('seminarModal').classList.remove('hidden');
        }

        function openCalendarModal() {
            document.getElementById('calendarModal').classList.remove('hidden');
            generateCalendar();
        }

        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function submitPrayer(event) {
            event.preventDefault();
            alert('Pedido de oração enviado com sucesso! Deus está ouvindo sua oração.');
            closeModal('prayerModal');
        }

        function submitDonation(event) {
            event.preventDefault();
            alert('Doação processada com sucesso! Que Deus abençoe generosamente sua oferta.');
            closeModal('donationModal');
        }

        function generateCalendar() {
            const calendarDays = document.getElementById('calendarDays');
            const now = new Date();
            const year = now.getFullYear();
            const month = now.getMonth();
            const firstDay = new Date(year, month, 1).getDay();
            const daysInMonth = new Date(year, month + 1, 0).getDate();
            
            let html = '';
            
            // Empty cells for days before month starts
            for (let i = 0; i < firstDay; i++) {
                html += '<div></div>';
            }
            
            // Days of the month
            for (let day = 1; day <= daysInMonth; day++) {
                const isToday = day === now.getDate();
                const hasEvent = [15, 18, 22].includes(day);
                html += `<div class="p-2 text-center border rounded cursor-pointer hover:bg-gray-100 ${isToday ? 'bg-purple-600 text-white' : ''} ${hasEvent ? 'font-bold' : ''}">${day}</div>`;
            }
            
            calendarDays.innerHTML = html;
        }

        // Simulate real-time updates
        setTimeout(() => {
            document.getElementById('prayerCount').textContent = '128';
            document.getElementById('seminarCount').textContent = '4';
            document.getElementById('eventCount').textContent = '6';
        }, 3000);
    </script>
</body>
</html>
