{{---@props(['name'])---}}
@if ($errors->any())
    <div class="bg-red-100 p-2 rounded text-red-800 text-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
