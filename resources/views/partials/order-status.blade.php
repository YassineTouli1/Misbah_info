@props(['status'])

@php
    $statusConfig = [
        'en_attente' => [
            'label' => 'En attente',
            'class' => 'bg-yellow-100 text-yellow-800',
            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'confirmee' => [
            'label' => 'Confirmée',
            'class' => 'bg-blue-100 text-blue-800',
            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
        ],
        'en_preparation' => [
            'label' => 'En préparation',
            'class' => 'bg-purple-100 text-purple-800',
            'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
        ],
        'prete' => [
            'label' => 'Prête',
            'class' => 'bg-green-100 text-green-800',
            'icon' => 'M5 13l4 4L19 7',
        ],
        'livree' => [
            'label' => 'Livrée',
            'class' => 'bg-indigo-100 text-indigo-800',
            'icon' => 'M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z',
        ],
        'annulee' => [
            'label' => 'Annulée',
            'class' => 'bg-red-100 text-red-800',
            'icon' => 'M6 18L18 6M6 6l12 12',
        ],
        'retournee' => [
            'label' => 'Retournée',
            'class' => 'bg-gray-100 text-gray-800',
            'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15',
        ],
    ];
    
    $config = $statusConfig[$status] ?? [
        'label' => $status,
        'class' => 'bg-gray-100 text-gray-800',
        'icon' => 'M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
    ];
    
    $size = $attributes->get('size', 'md');
    $sizes = [
        'xs' => 'text-xs px-2 py-0.5',
        'sm' => 'text-sm px-2.5 py-0.5',
        'md' => 'text-sm px-3 py-1',
        'lg' => 'text-base px-4 py-1.5',
    ][$size];
    
    $showIcon = $attributes->get('show-icon', true);
    $iconSize = [
        'xs' => 'h-3 w-3',
        'sm' => 'h-3.5 w-3.5',
        'md' => 'h-4 w-4',
        'lg' => 'h-5 w-5',
    ][$size];
    
    $class = 'inline-flex items-center rounded-full font-medium ' . $sizes . ' ' . $config['class'];
    
    if ($attributes->has('class')) {
        $class .= ' ' . $attributes->get('class');
    }
@endphp

<span {{ $attributes->merge(['class' => $class]) }}>
    @if($showIcon)
        <svg class="-ml-0.5 mr-1.5 {{ $iconSize }}" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $config['icon'] }}" />
        </svg>
    @endif
    {{ $config['label'] }}
</span>
