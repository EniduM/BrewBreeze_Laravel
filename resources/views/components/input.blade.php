@props(['disabled' => false])

<input {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'border-2 border-brew-light-brown/30 focus:border-brew-light-brown focus:ring-brew-light-brown rounded-xl shadow-sm font-sans text-brew-brown placeholder-brew-brown/40 transition-all duration-200']) !!}>
