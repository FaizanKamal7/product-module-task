@extends('layouts.app')

@section('title', 'Products')

@section('content')
    <h1 class="text-3xl font-bold text-center mb-8">Upload Product</h1>

    <div class="mb-8 flex justify-center">
        <div class="w-full max-w-md">
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="fileInput" class="block text-sm font-medium text-gray-700 mb-2">Upload File</label>
                <input id="fileInput" type="file" name="file"
                    class="block w-full text-sm text-gray-500
                file:mr-4 file:py-2 file:px-4
                file:rounded-full file:border-0
                file:text-sm file:font-semibold
                file:bg-blue-50 file:text-blue-700
                hover:file:bg-blue-100
            ">
                <button type="submit"
                    class="w-full m-2 bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline transition duration-300">
                    Upload
                </button>
            </form>
        </div>
    </div>
@endsection
