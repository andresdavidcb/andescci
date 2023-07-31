@props([
    'leadingAddOn' => false,
])

<div class="flex shadow-sm rounded-3xl">
    @if ($leadingAddOn)
        <span class="inline-flex items-center px-3 text-gray-500 bg-gray-50 sm:text-sm" >
            {{ $leadingAddOn }}
        </span>
    @endif

    <input type="password" {{ $attributes->merge(['class' => 'p-2 flex-1 form-input  block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5 rounded-3xl border-white']) }} />
</div>
