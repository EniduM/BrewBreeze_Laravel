<!-- Modern rounded button with coffee theme -->
<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-6 py-3 bg-[#6B4423] hover:bg-[#5A3A1E] border border-transparent rounded-full font-semibold text-sm text-white tracking-wide hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-[#6B4423] focus:ring-offset-2 disabled:opacity-50 transition-all duration-200']) }}>
    {{ $slot }}
</button>
