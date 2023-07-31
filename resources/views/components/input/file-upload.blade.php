@props([
    'filename' => 'No hay archivo seleccionado'
])

<div class="flex items-center">
    {{ $slot }}

    <div x-data="{ focused: false }">
        <span class="ml-5 shadow-sm rounded-3xl">
            <input @focus="focused = true" @blur="focused = false" class="sr-only" type="file" {{ $attributes }}>
            <label for="{{ $attributes['id'] }}" :class="{ 'outline-none border-blue-300 shadow-outline-blue': focused }" class="px-3 py-2 text-sm font-medium leading-4 text-gray-700 transition duration-150 ease-in-out border border-gray-300 cursor-pointer rounded-3xl hover:text-gray-500 active:bg-gray-50 active:text-gray-800">
                Seleccionar Archivo: {{ $filename }}
            </label>
        </span>
    </div>
</div>
