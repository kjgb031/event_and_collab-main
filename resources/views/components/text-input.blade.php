<div class="mb-4">
    <label for="{{ $name }}">{{ $label }}</label>
    <input
        class="block w-full px-4 py-2 mt-2 text-gray-700 bg-white border border-gray-300 rounded-md focus:border-blue-500 focus:outline-none focus:ring"
         @if(!$attributes->has('type')) type="text" @endif
         id="{{ $name }}" name="{{ $name }}" {{ $attributes }}>
</div>
