@props(['submit'])

<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-3 md:gap-8 p-6 md:p-8']) }}>
    <x-section-title>
        <x-slot name="title">{{ $title }}</x-slot>
        <x-slot name="description">{{ $description }}</x-slot>
    </x-section-title>

    <div class="mt-6 md:mt-0 md:col-span-2">
        <form wire:submit="{{ $submit }}">
            <div class="px-6 py-6 bg-white sm:px-8 sm:py-8 {{ isset($actions) ? 'rounded-t-xl' : 'rounded-xl' }}">
                <div class="grid grid-cols-6 gap-6">
                    {{ $form }}
                </div>
            </div>

            @if (isset($actions))
                <div class="flex items-center justify-end px-6 py-5 bg-brew-cream/30 text-end sm:px-8 rounded-b-xl border-t border-brew-light-brown/10">
                    {{ $actions }}
                </div>
            @endif
        </form>
    </div>
</div>
