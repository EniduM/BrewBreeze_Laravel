<!-- Modern Card-Based UI for Profile Sections -->
<div {{ $attributes->merge(['class' => 'p-6 md:p-8']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-6">
        <div class="px-6 py-6 sm:px-8 sm:py-8 bg-white rounded-2xl shadow-sm">
            {{ $content }}
        </div>
    </div>
</div>
