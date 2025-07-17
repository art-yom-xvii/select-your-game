@extends('layouts.app')

@section('title', $category->name . ' Category')

@section('content')
    <section class="py-12 bg-white">
        <div class="container mx-auto px-4">
            <div class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-900 mb-2">{{ $category->name }}</h1>
                @if ($category->description)
                    <p class="text-gray-600">{{ $category->description }}</p>
                @endif
            </div>

            @if ($products->isNotEmpty())
                <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                    @foreach ($products as $product)
                        @include('products.card', ['product' => $product])
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $products->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <p class="text-gray-600 text-xl">No games found in this category.</p>
                </div>
            @endif
        </div>
    </section>
@endsection
