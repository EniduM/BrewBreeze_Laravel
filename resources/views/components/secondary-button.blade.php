<!-- Modern rounded secondary button -->
<button {{ $attributes->merge(['type' => 'button', 'class' => 'inline-flex items-center px-6 py-3 bg-white hover:bg-gray-50 border border-gray-300 rounded-full font-semibold text-sm text-gray-700 tracking-wide shadow-sm hover:shadow-md focus:outline-none focus:ring-2 focus:ring-[#6B4423] focus:ring-offset-2 disabled:opacity-50 transition-all duration-200']) }}>
    {{ $slot }}
</button>
