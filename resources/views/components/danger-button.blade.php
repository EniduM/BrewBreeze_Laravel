<!-- Modern rounded danger button -->
<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center justify-center px-6 py-3 bg-red-600 hover:bg-red-500 border border-transparent rounded-full font-semibold text-sm text-white tracking-wide hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 disabled:opacity-50 transition-all duration-200']) }}>
    {{ $slot }}
</button>
