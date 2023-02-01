<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        crossorigin="anonymous">
    <title>Laravel Search</title>
</head>

<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Dashboard') }}
            </h2>
        </x-slot>
        <div>
            <h1 class="text-center mt-5">welcome to telefrek</h1>
        </div>
    </x-app-layout>

    <div class="container my-5 py-5 px-5 mx-5">
        <!-- Search input -->
        <!-- List items -->
        <div class="container my-5 py-5 px-5 mx-5">
            <!-- Search input -->
            <form>
                <input type="search" class="form-control" placeholder="Find user here" name="search">
            </form>

            <!-- List items -->
            <ul class="list-group mt-3">

                {{-- @foreach ($users as $user)
                    <li class="list-group-item">{{ $user->name }}</li>
                @endforeach --}}

            </ul>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous">
        </script>
</body>

</html
