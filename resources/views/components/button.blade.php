<span class="inline-flex">
    <button
        {{ $attributes->merge([
            'type' => 'button',
            'class' => 'py-2 px-4 text-sm leading-5 font-medium transition duration-150 ease-in-out' . ($attributes->get('disabled') ? ' opacity-75 cursor-not-allowed' : ''),
        ]) }}
    >
        {{ $slot }}
    </button>
</span>
