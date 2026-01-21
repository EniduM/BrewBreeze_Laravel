<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-8 p-6 md:p-8']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-6 md:mt-0 md:col-span-2">
        <div class="px-6 py-6 sm:px-8 sm:py-8 bg-white rounded-xl">
            {{ $content }}
        </div>
    </div>
</div>
