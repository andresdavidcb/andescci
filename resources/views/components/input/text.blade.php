<div class="flex shadow-sm rounded-3xl">
    <span class="inline-flex items-center px-3 text-gray-500 rounded-l-3xl bg-gray-50 sm:text-sm" >
        <img src="{{ url('img/Input.svg') }}" alt="" width="40px">
    </span>

    <input type="text" {{ $attributes->merge(['class' => 'rounded-r-3xl rounded-l-none p-2 flex-1 form-input  block w-full transition duration-150 ease-in-out sm:text-sm sm:leading-5  border-white']) }} />
</div>
