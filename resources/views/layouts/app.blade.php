<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <!-- Scripts -->
</head>
<body>

<div class="container">

        <img src="https://jobsbiwta.gov.bd/website/wp-content/uploads/2013/06/biwta_banner_new-03-copy.jpg" alt="" style="width: 100%; max-height: 200px" />

    <nav class="navbar navbar-expand-lg  mt-1 navbar-dark bg-primary mb-5">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('/')) ? 'active' : '' }}" aria-current="page" href="{{URL::to('/')}}">Current Job  Circular</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('printCopy')) ? 'active' : '' }}" href="{{route('PrintCopy')}}">Applicant  Copy Print</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('writtenCopy')) ? 'active' : '' }}" href="{{route('writtenCopy')}}">লিখিত পরীক্ষার প্রবেশ পত্র</a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link {{ (request()->is('vivaCopy')) ? 'active' : '' }}" href="{{route('vivaCopy')}}">মৌখিক পরীক্ষার প্রবেশ পত্র</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('practicalCopy')) ? 'active' : '' }}" href="{{route('practicalCopy')}}">ব্যবহারিক পরীক্ষার প্রবেশ পত্র</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ (request()->is('medicalCopy')) ? 'active' : '' }}" href="{{route('medicalCopy')}}">ব্বাস্থ্য পরীক্ষার প্রবেশপত্র</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Search Applied ID</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
            @yield('content')
        </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace()
    </script>
@yield('script-bottom')
<style>
    .nav-link{
        color: white;
    }
</style>
</body>
</html>
