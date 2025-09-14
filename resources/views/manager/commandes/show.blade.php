@extends('layouts.app')

@section('content')
<div class="py-6" x-data="{ showNoteForm: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête avec retour et statut -->
        <div class="md:flex md:items-center md:justify-between mb-6">
            <div class="flex-1 min-w-0">
                <div class="flex items-center">
                    <a href="{{ route('manager.commandes.index') }}" class="text-indigo-600 hover:text-indigo-900 mr-4">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                        </svg>
                    </a>
                    <div>
                        <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                            Commande #{{ $commande->id }}
                        </h2>
                        <div class="mt-1">
                            @include('partials.order-status', ['status' => $commande->statut, 'size' => 'sm'])
                            @if($commande->statut === 'livree')
                                <span class="ml-2 text-sm text-gray-500">
                                    Livrée le {{ $commande->date_livraison->format('d/m/Y H:i') }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions de statut -->
            @include('manager.commandes._status_actions', ['commande' => $commande])
        </div>

        <!-- Informations principales -->
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <!-- Informations client -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Informations client</h3>
                        <div class="mt-2 space-y-1">
                            <p class="text-sm text-gray-900 flex items-center">
                                <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                {{ $commande->client->user->name }}
                            </p>
                            <p class="text-sm text-gray-600 flex items-center">
                                <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                {{ $commande->client->telephone }}
                            </p>
                            <p class="text-sm text-gray-600 flex items-start">
                                <svg class="h-4 w-4 mr-2 mt-0.5 flex-shrink-0 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>{{ $commande->client->adresse }}</span>
                            </p>
                            @if($commande->client->user->email)
                                <p class="text-sm text-gray-600 flex items-center">
                                    <svg class="h-4 w-4 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                    {{ $commande->client->user->email }}
                                </p>
                            @endif
                        </div>
                        
                        @if($commande->client->date_naissance)
                            <div class="mt-3 pt-3 border-t border-gray-100">
                                <p class="text-xs text-gray-500">Date de naissance</p>
                                <p class="text-sm text-gray-900">{{ $commande->client->date_naissance->format('d/m/Y') }}</p>
                            </div>
                        @endif
                    </div>
                    
                    <!-- Détails de la commande -->
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Détails de la commande</h3>
                        <div class="mt-2 space-y-2">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Date :</span> 
                                <span class="text-gray-900">{{ $commande->created_at->format('d/m/Y H:i') }}</span>
                            </p>
                            
                            <p class="text-sm">
                                <span class="font-medium text-gray-600">Statut :</span> 
                                @include('partials.order-status', ['status' => $commande->statut, 'size' => 'sm'])
                            </p>
                            
                            @if($commande->date_livraison)
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Livraison :</span> 
                                    <span class="text-gray-900">{{ $commande->date_livraison->format('d/m/Y H:i') }}</span>
                                </p>
                            @endif
                            
                            <div class="pt-2 mt-2 border-t border-gray-100">
                                @if($commande->is_paid)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-green-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        Paiement reçu
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                        <svg class="-ml-0.5 mr-1.5 h-2 w-2 text-yellow-400" fill="currentColor" viewBox="0 0 8 8">
                                            <circle cx="4" cy="4" r="3" />
                                        </svg>
                                        En attente de paiement
                                    </span>
                                @endif
                                
                                @if($commande->mode_paiement)
                                    <p class="mt-1 text-sm text-gray-600">
                                        <span class="font-medium">Moyen de paiement :</span> 
                                        <span class="capitalize">{{ $commande->mode_paiement }}</span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div>
                        <h3 class="text-lg leading-6 font-medium text-gray-900">Résumé</h3>
                        <div class="mt-2">
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Articles :</span> {{ $commande->menuItems->sum('pivot.quantity') }}
                            </p>
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Sous-total :</span> {{ number_format($commande->total, 2, ',', ' ') }} €
                            </p>
                            @if($commande->frais_livraison > 0)
                                <p class="text-sm text-gray-600">
                                    <span class="font-medium">Frais de livraison :</span> {{ number_format($commande->frais_livraison, 2, ',', ' ') }} €
                                </p>
                            @endif
                            <p class="text-lg font-medium text-gray-900 mt-1">
                                Total : {{ number_format($commande->total + $commande->frais_livraison, 2, ',', ' ') }} €
                            </p>
                        </div>
                    </div>
                </div>
                
                @if($commande->notes)
                    <div class="mt-6">
                        <h4 class="text-sm font-medium text-gray-900">Notes :</h4>
                        <div class="mt-1 p-3 bg-yellow-50 rounded-md">
                            <p class="text-sm text-yellow-700 whitespace-pre-line">{{ $commande->notes }}</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="bg-white shadow overflow-hidden sm:rounded-lg mb-6">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Articles commandés</h3>
            </div>
            <div class="border-t border-gray-200">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Article
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Prix unitaire
                            </th>
                            <th scope="col" class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Quantité
                            </th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($commande->menuItems as $item)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900">{{ $item->nom }}</div>
                                    @if($item->pivot->notes)
                                        <div class="text-xs text-gray-500 mt-1">{{ $item->pivot->notes }}</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                    {{ number_format($item->pivot->price, 2, ',', ' ') }} €
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-center text-sm text-gray-500">
                                    {{ $item->pivot->quantity }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium text-gray-900">
                                    {{ number_format($item->pivot->price * $item->pivot->quantity, 2, ',', ' ') }} €
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gray-50">
                        <tr>
                            <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                                Sous-total
                            </th>
                            <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                {{ number_format($commande->total, 2, ',', ' ') }} €
                            </td>
                        </tr>
                        @if($commande->frais_livraison > 0)
                            <tr>
                                <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-500">
                                    Frais de livraison
                                </th>
                                <td class="px-6 py-3 text-right text-sm font-medium text-gray-900">
                                    {{ number_format($commande->frais_livraison, 2, ',', ' ') }} €
                                </td>
                            </tr>
                        @endif
                        <tr>
                            <th colspan="3" class="px-6 py-3 text-right text-lg font-bold text-gray-900">
                                Total
                            </th>
                            <td class="px-6 py-3 text-right text-lg font-bold text-gray-900">
                                {{ number_format($commande->total + $commande->frais_livraison, 2, ',', ' ') }} €
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Historique des modifications</h3>
            </div>
            <div class="border-t border-gray-200">
                <div class="px-4 py-5 sm:p-6">
                    @if($commande->activities->count() > 0)
                        <div class="flow-root">
                            <ul class="-mb-8">
                                @foreach($commande->activities->sortByDesc('created_at') as $activity)
                                    <li>
                                        <div class="relative pb-8">
                                            @if(!$loop->last)
                                                <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true"></span>
                                            @endif
                                            <div class="relative flex space-x-3">
                                                <div>
                                                    @php
                                                        $iconClasses = [
                                                            'created' => 'bg-blue-500',
                                                            'updated' => 'bg-yellow-500',
                                                            'deleted' => 'bg-red-500',
                                                            'status_changed' => 'bg-purple-500',
                                                            'paid' => 'bg-green-500',
                                                        ][$activity->event] ?? 'bg-gray-400';
                                                        
                                                        $icon = [
                                                            'created' => 'M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-6-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20',
                                                            'updated' => 'M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z',
                                                            'deleted' => 'M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16',
                                                            'status_changed' => 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4',
                                                            'paid' => 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                                        ][$activity->event] ?? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z';
                                                    @endphp
                                                    <span class="h-8 w-8 rounded-full {{ $iconClasses }} flex items-center justify-center ring-8 ring-white">
                                                        <svg class="h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}" />
                                                        </svg>
                                                    </span>
                                                </div>
                                                <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                                    <div>
                                                        <p class="text-sm text-gray-500">
                                                            {!! $activity->description !!}
                                                            <span class="font-medium text-gray-900">{{ $activity->causer->name ?? 'Système' }}</span>
                                                        </p>
                                                        @if($activity->properties->has('attributes') && $activity->properties->get('attributes'))
                                                            <div class="mt-1 text-xs text-gray-500">
                                                                @foreach($activity->properties->get('attributes') as $key => $value)
                                                                    @if(!in_array($key, ['updated_at', 'created_at']))
                                                                        <div>
                                                                            <span class="font-medium">{{ $key }}:</span>
                                                                            @if($key === 'statut')
                                                                                @php
                                                                                    $statusLabels = [
                                                                                        'en_attente' => 'En attente',
                                                                                        'confirmee' => 'Confirmée',
                                                                                        'en_preparation' => 'En préparation',
                                                                                        'prete' => 'Prête',
                                                                                        'livree' => 'Livrée',
                                                                                        'annulee' => 'Annulée',
                                                                                        'retournee' => 'Retournée',
                                                                                    ];
                                                                                @endphp
                                                                                <span class="{{ in_array($value, ['annulee', 'retournee']) ? 'text-red-600' : 'text-gray-600' }}">
                                                                                    {{ $statusLabels[$value] ?? $value }}
                                                                                </span>
                                                                            @else
                                                                                <span class="text-gray-600">{{ $value }}</span>
                                                                            @endif
                                                                        </div>
                                                                    @endif
                                                                @endforeach
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="text-right text-sm whitespace-nowrap text-gray-500">
                                                        <time datetime="{{ $activity->created_at->toIso8601String() }}">
                                                            {{ $activity->created_at->diffForHumans() }}
                                                        </time>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <p class="text-sm text-gray-500">Aucune activité enregistrée pour cette commande.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('success')) 
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed bottom-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('success') }}</span>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" 
         x-show="show" 
         x-init="setTimeout(() => show = false, 5000)"
         class="fixed bottom-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg flex items-center space-x-2">
        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
        </svg>
        <span>{{ session('error') }}</span>
    </div>
@endif

@endsection
