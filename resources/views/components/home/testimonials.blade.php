<section class="py-16 bg-gray-50 dark:bg-gray-800">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-semibold text-gray-700 dark:text-gray-300">Lo que dicen nuestros usuarios</h2>
        <div class="flex justify-center mt-8 space-x-4">
            @foreach ($testimonials as $testimonial)
                <div class="bg-white shadow-lg rounded-lg p-6 w-80">
                    <p class="text-lg text-gray-700">{{ $testimonial['text'] }}</p>
                    <p class="mt-4 text-gray-500">- {{ $testimonial['author'] }}</p>
                </div>
            @endforeach
        </div>
    </div>
</section>
