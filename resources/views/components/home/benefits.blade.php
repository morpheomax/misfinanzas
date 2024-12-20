<section class="py-16 bg-white">
    <div class="container mx-auto px-6 grid grid-cols-1 md:grid-cols-3 gap-12">
        @foreach ($benefits as $benefit)
            <div
                class="{{ $benefit['bgColor'] }} rounded-lg shadow-lg p-8 text-center transform transition duration-300 hover:scale-105">
                <h3 class="text-xl font-semibold {{ $benefit['textColor'] }}">{{ $benefit['title'] }}</h3>
                <p class="mt-4 text-gray-600">
                    {{ $benefit['description'] }}
                </p>
            </div>
        @endforeach
    </div>
</section>
