<div class="md:col-span-1 flex justify-between">
    <div class="px-4 sm:px-0">
        <h3 class="text-2xl font-display font-bold text-brew-brown">{{ $title }}</h3>

        <p class="mt-2 text-sm text-brew-brown/70 font-sans">
            {{ $description }}
        </p>
    </div>

    <div class="px-4 sm:px-0">
        {{ $aside ?? '' }}
    </div>
</div>
