<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
    <title>@yield('title', setting('site.title'))</title>
    <meta name="description" content="@yield('description', setting('site.description'))"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        [v-cloak] {display: none}
    </style>
    <!-- Fonts -->


@php
    if(\Illuminate\Support\Facades\Route::currentRouteName()){
        $fonts = \App\Font::all();
        foreach ($fonts as $font){
        $font->url = url('/storage/'.$font->url);
        }
    }else{
        $fonts = [];
    }

@endphp
<!-- Styles -->
    <script>
        var fonts = JSON.parse('{!! json_encode($fonts) !!}');
        fonts.forEach((item) => {
            var junction_font = new FontFace(item.font_family, "url("+item.url+")");
            junction_font.load().then(function(loaded_face) {
                document.fonts.add(loaded_face);
            })
        });
    </script>
</head>
<body>
@php

        @endphp
<v-app id="app">
    <iframe ref="previewIframe" id="previewIframe" style="position: fixed; min-width: 2000px; min-height: 1500px" v-cloak src="{{url('/generate_preview')}}" v-if="$product.iframe"></iframe>
    @include('layouts.header')
    <v-content style="padding: 0px !important;">
        @yield('content')
    </v-content>
    @include('layouts.sidebar')
    <cart-component :show="cartShow"></cart-component>
    <errors></errors>
    {{--@include('layouts.footer')--}}
</v-app>
</body>
<script>
    var translations = JSON.parse('{!! json_encode(\Illuminate\Support\Facades\Lang::get('my')) !!}');
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
<script src="{{ asset('js/app.js') }}"></script>
@yield('js')
</html>
