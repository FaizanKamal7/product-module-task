@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1 class="text-3xl font-bold text-center mb-8">Product List</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">

        @if (isset($products) && !$products->isEmpty())
            @foreach ($products as $product)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    @if ($product->product_image != '')
                        <img src="{{ $product->product_image }}" alt="Product Image" class="w-full h-48 object-cover">
                    @else
                        <img src="https://tiimg.tistatic.com/fp/1/008/593/tyres-696.jpg" alt="Product Image"
                            class="w-full h-48 object-cover">
                    @endif
                    <div class="p-4">
                        <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                        <p class="text-gray-600 mb-4">{{ $product->manufacturer }}</p>
                        <p class="text-gray-600 mb-4">In stock: {{ $product->availability }}</p>
                        <p class="text-lg font-bold text-blue-600">Price: ${{ $product->price }}</p>
                    </div>
                </div>
            @endforeach
        @endif
    </div>

    <div class="pagination">
        {{ $products->links() }}
    </div>
@endsection
