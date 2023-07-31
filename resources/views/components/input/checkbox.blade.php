@props([
    'checkId' => '',
    // 'checked' => false,
    ])

<div class="flex space-x-2">
    <input {{ $attributes }}
        type="checkbox"
        class="mt-1 space-x-10 transition duration-150 ease-in-out border-white shadow-md rounded-3xl sm:text-sm sm:leading-5 "
        id="{{ $checkId }}"
    />

    <label for="{{ $checkId }}">{{ $slot }}</label>
</div>
