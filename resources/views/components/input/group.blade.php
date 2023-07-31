@props([
    'error' => false,
    'helpText' => false,
    'paddingless' => false,
    'borderless' => false,
])


<div class="sm:grid sm:grid-cols-3 sm:gap-4 sm:items-start {{ $borderless ? '' : ' sm:border-t ' }} sm:border-gray-200 {{ $paddingless ? '' : ' sm:py-5 ' }}">

    {{ $labels ?? '' }}

    <div class="mt-1 sm:mt-0 sm:col-span-2">
        {{ $slot }}

        @if ($error)
            <div class="mt-1 text-sm text-red-500">{{ $error }}</div>
        @endif

        @if ($helpText)
            <p class="mt-2 text-sm text-gray-500">{{ $helpText }}</p>
        @endif
    </div>
</div>
