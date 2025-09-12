@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-semibold mb-6">Nouvelle Commande</h2>
                
                <form action="{{ route('client.commandes.store') }}" method="POST">
                    @csrf
                    
                    <div class="mb-8">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Menu</h3>
                        
                        @if($menuItems->count() > 0)
                            <div class="space-y-4">
                                @foreach($menuItems as $item)
                                    <div class="flex items-center justify-between p-4 border rounded-lg">
                                        <div>
                                            <h4 class="font-medium text-gray-900">{{ $item->nom }}</h4>
                                            <p class="text-sm text-gray-600">{{ $item->description }}</p>
                                            <p class="text-sm font-medium text-gray-900 mt-1">
                                                {{ number_format($item->prix, 2, ',', ' ') }} €
                                            </p>
                                        </div>
                                        <div class="flex items-center">
                                            <button type="button" 
                                                    onclick="decrement({{ $item->id }})" 
                                                    class="px-3 py-1 border border-gray-300 rounded-l-md bg-gray-50 text-gray-600 hover:bg-gray-100">
                                                -
                                            </button>
                                            <input type="number" 
                                                   id="quantity-{{ $item->id }}" 
                                                   name="menu_items[{{ $loop->index }}][quantity]" 
                                                   value="0" 
                                                   min="0" 
                                                   class="w-16 text-center border-t border-b border-gray-300 py-1"
                                                   onchange="updateTotal()">
                                            <input type="hidden" name="menu_items[{{ $loop->index }}][id]" value="{{ $item->id }}">
                                            <button type="button" 
                                                    onclick="increment({{ $item->id }})" 
                                                    class="px-3 py-1 border border-gray-300 rounded-r-md bg-gray-50 text-gray-600 hover:bg-gray-100">
                                                +
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-gray-500">Aucun article disponible pour le moment.</p>
                        @endif
                    </div>
                    
                    <div class="mb-8">
                        <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">
                            Notes supplémentaires (facultatif)
                        </label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="3" 
                                  class="shadow-sm focus:ring-indigo-500 focus:border-indigo-500 mt-1 block w-full sm:text-sm border border-gray-300 rounded-md"
                                  placeholder="Allergies, instructions spéciales, etc."></textarea>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg mb-6">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-medium text-gray-900">Total :</span>
                            <span id="total-amount" class="text-2xl font-bold text-indigo-600">0,00 €</span>
                        </div>
                    </div>
                    
                    <div class="flex justify-end space-x-4">
                        <a href="{{ route('client.commandes.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            Annuler
                        </a>
                        <button type="submit" id="submit-btn" disabled class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50 disabled:cursor-not-allowed">
                            Passer la commande
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Prix des articles
    const prices = @json($menuItems->pluck('prix', 'id'));
    
    // Mettre à jour le total
    function updateTotal() {
        let total = 0;
        
        // Parcourir tous les champs de quantité
        document.querySelectorAll('input[type="number"]').forEach(input => {
            const itemId = input.id.replace('quantity-', '');
            const quantity = parseInt(input.value) || 0;
            const price = prices[itemId] || 0;
            total += quantity * price;
        });
        
        // Mettre à jour l'affichage du total
        document.getElementById('total-amount').textContent = 
            total.toFixed(2).replace('.', ',') + ' €';
        
        // Activer/désactiver le bouton de soumission
        document.getElementById('submit-btn').disabled = total <= 0;
    }
    
    // Incrémenter la quantité
    function increment(itemId) {
        const input = document.getElementById(`quantity-${itemId}`);
        input.value = parseInt(input.value || 0) + 1;
        updateTotal();
    }
    
    // Décrémenter la quantité
    function decrement(itemId) {
        const input = document.getElementById(`quantity-${itemId}`);
        const value = parseInt(input.value || 0);
        if (value > 0) {
            input.value = value - 1;
            updateTotal();
        }
    }
    
    // Initialiser le total au chargement de la page
    document.addEventListener('DOMContentLoaded', updateTotal);
</script>
@endpush
@endsection
