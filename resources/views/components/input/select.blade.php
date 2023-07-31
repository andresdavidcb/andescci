@props([
    'placeholder' => null,
    'trailingAddOn' => null,
])

<div class="flex">
    <select {{ $attributes->merge(['class' => ' shadow-sm form-select block w-full pl-3 pr-10 py-2 text-base leading-6 border-white focus:outline-none focus:shadow-outline-blue focus:border-blue-300 sm:text-sm sm:leading-5 rounded-3xl']) }}>
    @if ($placeholder)
        <option disabled value="">{{ $placeholder }}</option>
    @endif

    {{ $slot }}
    </select>

    @if ($trailingAddOn)
        {{ $trailingAddOn }}
    @endif
</div>
