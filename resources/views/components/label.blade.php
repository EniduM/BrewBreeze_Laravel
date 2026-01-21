@props(['value'])

<label {{ $attributes->merge(['class' => 'block font-sans font-semibold text-sm text-brew-brown mb-2']) }}>
    {{ $value ?? $slot }}
</label>
