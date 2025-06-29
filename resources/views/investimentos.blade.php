<title>FinPlan</title>

<x-app-layout>
    
    <div class="flex justify-between items-center p-4 md:p-6 border-b-2 border-primary-1 shadow-sm">
        <h2 class="text-3xl font-bold text-primary-1">
            Sugestão de investimentos
        </h2>
        <div class="text-right">
            <p class="text-sm text-gray-600">Seu saldo atual</p>
            <p class="text-xl font-semibold text-gray-800">{{number_format($user_rent, 2, ',', '.')}}</p>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded-lg">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Cabeçalho com informações do perfil -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                        <div>
                            <h3 class="text-xl font-semibold text-gray-900 mb-1">Seu perfil de investidor</h3>
                            <p class="text-sm text-gray-600">
                                @php
                                    $profileInfo = [
                                        'conservador' => 'Você prefere investimentos mais seguros, com baixo risco e retornos mais previsíveis.',
                                        'moderado' => 'Você busca um equilíbrio entre risco e retorno, aceitando alguma volatilidade por maiores ganhos.',
                                        'arrojado' => 'Você está disposto a assumir mais riscos em busca de retornos potencialmente maiores.'
                                    ];
                                @endphp
                                {{ $profileInfo[auth()->user()->type_user] }}
                            </p>
                        </div>
                        <div>
                            <span class="px-4 py-1.5 rounded-full text-sm font-semibold shadow-sm
                                @if(auth()->user()->type_user === 'conservador')
                                    bg-green-100 text-green-800
                                @elseif(auth()->user()->type_user === 'moderado')
                                    bg-yellow-100 text-yellow-800
                                @else
                                    bg-red-100 text-red-800
                                @endif
                            ">
                                {{ ucfirst(auth()->user()->type_user) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Grid de Investimentos -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">
                    <div class="mb-6">
                        <h3 class="text-lg font-medium text-gray-900 mb-2">Investimentos recomendados</h3>
                        <p class="text-sm text-gray-600">
                            Com base no seu perfil de investidor, selecionamos as melhores opções para você.
                        </p>
                    </div>

                    @if($investiments->count() > 0)
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                            @foreach($investiments as $investiment)
                                <div class="border border-primary rounded-lg p-4 bg-white shadow-sm flex flex-col gap-2 hover:border-primary-1 transition">
                                    <div class="flex items-center justify-between mb-1">
                                        <span class="font-semibold text-gray-800 text-base">{{ $investiment->investiment_name }}</span>
                                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                                            @if($investiment->investiment_type === 'Renda Fixa')
                                                bg-blue-100 text-blue-800
                                            @elseif($investiment->investiment_type === 'Fundos Imobiliários')
                                                bg-purple-100 text-purple-800
                                            @elseif($investiment->investiment_type === 'Ações')
                                                bg-green-100 text-green-800
                                            @elseif($investiment->investiment_type === 'ETF')
                                                bg-yellow-100 text-yellow-800
                                            @elseif($investiment->investiment_type === 'Criptomoedas')
                                                bg-orange-100 text-orange-800
                                            @else
                                                bg-gray-100 text-gray-800
                                            @endif
                                        ">
                                            {{ $investiment->investiment_type }}
                                        </span>
                                    </div>
                                    <div class="text-sm text-gray-600 mb-1">{{ $investiment->investiment_description }}</div>
                                    <div class="flex flex-wrap gap-3 text-xs mt-2">
                                        <div class="flex items-center gap-1">
                                            <span class="font-medium text-gray-500">Valor mínimo:</span>
                                            <span class="font-semibold text-gray-700">R$ {{ number_format($investiment->minimum_value, 2, ',', '.') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="font-medium text-gray-500">Expira em:</span>
                                            <span class="text-gray-700">{{ \Carbon\Carbon::parse($investiment->expiration_date)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="flex items-center gap-1">
                                            <span class="font-medium text-gray-500">Perfil:</span>
                                            <span class="px-2 py-0.5 rounded-full font-medium
                                                @if($investiment->recommended_profile === 'conservador')
                                                    bg-green-100 text-green-800
                                                @elseif($investiment->recommended_profile === 'moderado')
                                                    bg-yellow-100 text-yellow-800
                                                @else
                                                    bg-red-100 text-red-800
                                                @endif
                                            ">
                                                {{ ucfirst($investiment->recommended_profile) }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-1">Nenhum investimento encontrado</h3>
                            <p class="text-gray-500">Não há investimentos recomendados para o seu perfil no momento.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>