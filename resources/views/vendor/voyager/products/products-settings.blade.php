<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <title>Laravel</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @include('partials.fonts')
    <!-- Fonts -->

    <!-- Styles -->
</head>
<body>
<v-app id="app">
    <v-content>
        <div class="flex-center position-ref">
            <div class="ma-auto">
                <products-placeholder></products-placeholder>
            </div>
        </div>
    </v-content>
</v-app>
</body>
<script>
    var session_errors = JSON.parse('{!! json_encode($errors->all()) !!}');
            @if(\Illuminate\Support\Facades\App::getLocale() != 'pl')
    var lang_slug = '/{{\Illuminate\Support\Facades\App::getLocale()}}';
            @else
    var lang_slug = '';
            @endif
    var base_url= "{{url('/')}}";
    var relative_url = "{{url('/')}}"+lang_slug;
    var lang_slug = "{{(\Illuminate\Support\Facades\App::getLocale() != 'pl')? \Illuminate\Support\Facades\App::getLocale() : ''}}"
</script>
<script src="{{ asset('js/app.js') }}" defer></script>
</html>
