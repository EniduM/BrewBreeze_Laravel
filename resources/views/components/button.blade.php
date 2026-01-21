<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-brew-light-brown border border-transparent rounded-xl font-sans font-bold text-sm text-white uppercase tracking-wider hover:bg-brew-orange focus:bg-brew-light-brown active:bg-brew-orange focus:outline-none focus:ring-2 focus:ring-brew-light-brown focus:ring-offset-2 disabled:opacity-50 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5']) }}>
    {{ $slot }}
</button>
