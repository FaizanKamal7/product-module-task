<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Default Title')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @yield('additional_head')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    @include('includes.header')

    <main class="container mx-auto px-6 py-8">
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4"
                role="alert">
                <p>{{ session('success') }}</p>
            </div>
        @endif

        @yield('content')
    </main>

    @include('includes.footer')

    @yield('scripts')
</body>

</html>
