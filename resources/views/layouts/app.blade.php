<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'AdvBlogger') }}</title>
    @yield('style')
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
    <div id="app">
       @include('layouts.navbar')
        <div class="conatiner">
            <div class="row"> 
                <div class="col-12 col-md-9">
                    <div class="panel panel-primary">
                        <div class="panel-heading">@yield('panel-heading')</div>
                            <div class="panel-body">
                                @include('layouts.messages')
                                @yield('content')
                            </div>
                        </div>
                    </div>
                    @includeWhen(!in_array('guest',request()->route()->middleware()),'layouts.sidebar', ['archives' => \App\Post::archives()])
                    
                </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/vue/2.5.2/vue.common.js"></script>
    @yield('script')
</body>
</html>
