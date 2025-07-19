@forelse ($products as $product)
    <div class="bg-white rounded-lg shadow overflow-hidden game-card-hover">
        <a href="{{ route('products.show', $product->slug) }}">
            <div class="relative aspect-[3/4] bg-gray-200">
                @if ($product->primaryImage)
                    <img src="{{ $product->primaryImage->image_path }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover">
                @endif

                @if ($product->platform && $product->product_type === 'game')
                    <div class="absolute top-2 left-2">
                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium text-white"
                            style="background-color: @if ($product->platform->slug === 'playstation-4') var(--color-ps4)
                            @elseif ($product->platform->slug === 'xbox-one') var(--color-xbox)
                            @elseif ($product->platform->slug === 'nintendo-switch') var(--color-nintendo)
                            @else #6b7280
                            @endif;">
                            {{ $product->platform->name }}
                        </span>
                    </div>
                @endif
            </div>
        </a>

        <div class="p-4">
            <h3 class="text-lg font-medium mb-1 truncate">
                <a href="{{ route('products.show', $product->slug) }}" class="text-gray-900 hover:text-primary">{{ $product->name }}</a>
            </h3>
            <div class="text-gray-500 text-sm mb-2">
                @if ($product->publisher && $product->product_type === 'game')
                    <span>{{ $product->publisher }}</span>
                @endif
            </div>
            <div class="flex justify-between items-center">
                <div>
                    @if ($product->compare_at_price && $product->compare_at_price > $product->price)
                        <span class="text-gray-500 line-through text-sm">${{ number_format($product->compare_at_price, 2) }}</span>
                    @endif
                    <span class="text-lg font-bold text-gray-900">${{ number_format($product->price, 2) }}</span>
                </div>
                <form action="{{ route('cart.store', [], true) }}" method="POST">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="bg-primary hover:bg-primary-dark text-white rounded-full w-10 h-10 flex items-center justify-center cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
@empty
    <div class="col-span-full text-center py-8">
        <p class="text-gray-500">No products found matching your criteria.</p>
        <a href="{{ route('products.index') }}" class="mt-4 inline-block bg-secondary hover:bg-secondary-dark text-white py-2 px-4 rounded">Clear All Filters</a>
    </div>
@endforelse

{{-- Add notification popup --}}
<div id="add-to-cart-notification" class="fixed top-6 right-6 z-50 bg-secondary text-white px-4 py-2 rounded shadow-lg hidden transition-opacity duration-300"></div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // AJAX add to cart for product cards
    document.querySelectorAll('.game-card-hover form[action*="cart"]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(form);
            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                showAddToCartNotification(data.message || 'Added to cart!');
                if (typeof data.cart_count !== 'undefined') {
                    const cartCountElem = document.getElementById('cart-counter');
                    if (cartCountElem) cartCountElem.textContent = data.cart_count;
                }
            })
            .catch(() => {
                showAddToCartNotification('Could not add to cart.');
            });
        });
    });

    function showAddToCartNotification(message) {
        const notif = document.getElementById('add-to-cart-notification');
        notif.textContent = message;
        notif.classList.remove('hidden');
        notif.style.opacity = 1;
        setTimeout(() => {
            notif.style.opacity = 0;
            setTimeout(() => notif.classList.add('hidden'), 300);
        }, 2000);
    }
});
</script>
@endpush
