<!-- Modern section title with cleaner typography -->
<div class="flex justify-between mb-4">
    <div>
        <h3 class="text-xl font-semibold text-gray-900">{{ $title }}</h3>

        <p class="mt-1 text-sm text-gray-600">
            {{ $description }}
        </p>
    </div>

    <div>
        {{ $aside ?? '' }}
    </div>
</div>
