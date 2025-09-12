@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-center mb-6">
                    <h2 class="text-2xl font-semibold">Commande #{{ $commande->id }}</h2>
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ 
                        $commande->statut === 'en_attente' ? 'bg-yellow-100 text-yellow-800' : 
                        ($commande->statut === 'confirmee' ? 'bg-blue-100 text-blue-800' :
                        ($commande->statut === 'en_preparation' ? 'bg-purple-100 text-purple-800' :
                        ($commande->statut === 'prete' ? 'bg-green-100 text-green-800' :
                        ($commande->statut === 'livree' ? 'bg-green-100 text-green-800' :
                        ($commande->statut === 'annulee' ? 'bg-red-100 text-red-800' : 'bg-gray-100 text-gray-800'))))) }}">
                        {{ ucfirst(str_replace('_', ' ', $commande->statut)) }}
                    </span>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-2">Détails de la commande</h3>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Date :</span> {{ $commande->created_at->format('d/m/Y H:i') }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <span class="font-medium">Total :</span> {{ number_format($commande->total, 2, ',', ' ') }} €
                        </p>
                        @if($commande->date_livraison)
                            <p class="text-sm text-gray-600">
                                <span class="font-medium">Livraison :</span> {{ $commande->date_livraison->format('d/m/Y H:i') }}
                            </p>
                        @endif
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h3 class="font-medium text-gray-900 mb-2">Informations client</h3>
                        <p class="text-sm text-gray-600">{{ $commande->client->user->name }}</p>
                        <p class="text-sm text-gray-600">{{ $commande->client->telephone }}</p>
                        <p class="text-sm text-gray-600">{{ $commande->client->adresse }}</p>
                    </div>
                    
                    @if($commande->notes)
                        <div class="bg-yellow-50 p-4 rounded-lg">
                            <h3 class="font-medium text-yellow-900 mb-2">Notes</h3>
                            <p class="text-sm text-yellow-800 whitespace-pre-line">{{ $commande->notes }}</p>
                        </div>
                    @endif
                </div>
                
                <h3 class="text-lg font-medium text-gray-900 mb-4">Articles commandés</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Article
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Prix unitaire
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Quantité
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Total
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($commande->menuItems as $item)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->nom }}</div>
                                        <div class="text-sm text-gray-500">{{ $item->description }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ number_format($item->pivot->price, 2, ',', ' ') }} €
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $item->pivot->quantity }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ number_format($item->pivot->price * $item->pivot->quantity, 2, ',', ' ') }} €
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <td colspan="3" class="text-right px-6 py-4 text-sm font-medium text-gray-500">
                                    Sous-total
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ number_format($commande->total, 2, ',', ' ') }} €
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                
                <div class="mt-8 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                    <a href="{{ route('client.commandes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                        &larr; Retour à la liste des commandes
                    </a>
                    
                    @can('cancel', $commande)
                        <form action="{{ route('client.commandes.annuler', $commande) }}" method="POST" class="inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500"
                                    onclick="return confirm('Êtes-vous sûr de vouloir annuler cette commande ?')">
                                Annuler la commande
                            </button>
                        </form>
                    @endcan
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
