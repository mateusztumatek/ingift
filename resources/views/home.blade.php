@extends('layouts.app')
@section('content')
    <div style="height: 60vh" class="w-100 primary" style="overflow: hidden">
        <img src="{{url('/storage/default/banner.jpg')}}" class="w-100" style="object-fit: cover; height: 100%">
    </div>
    <div class="container" v-cloak>
        <v-card class="col-md-8 col-sm-12 mx-auto elevation-8" style="border-radius: 16px; margin-top: -70px">
            <v-card-text class="py-5">
                <div class="row">
                    <div class="col-md-4">
                        <div class="d-flex align-center">
                            <img style="opacity: 0.3; max-width: 50px" class="mr-5" src="{{url('/storage/default/truck.svg')}}">
                            <h3 style="font-size: 1.5rem">Szybka dostawa</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-center">
                            <img style="opacity: 0.3; max-width: 50px" class="mr-5" src="{{url('/storage/default/box.svg')}}">
                            <h3 style="font-size: 1.5rem">Gwarancja prezentu na czas</h3>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="d-flex align-center">
                            <img style="opacity: 0.3; max-width: 50px" class="mr-5" src="{{url('/storage/default/money.svg')}}">
                            <h3 style="font-size: 1.5rem">Darmowy zwrot przez 30 dni</h3>
                        </div>
                    </div>
                </div>
            </v-card-text>
        </v-card>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <v-card class="product elevation-0">
                    <v-img src="{{url('/storage/'.$promotion->main_image)}}" style="opacity: 0.5; position: absolute; top: 0px" height="400px"></v-img>
                    <v-img class="primary-image" src="{{url('/storage/'.$promotion->main_image)}}" height="400px"></v-img>
                    <div style="height: 100%" class="content">
                        <div class="pa-3">
                            <h2 class="white--text">{{$promotion->name}}</h2>
                        </div>
                    </div>
                </v-card>
            </div>
        </div>
    </div>
    @endsection
    @section('js')
        <script>
            Vue.prototype.$eventBus.$emit('header-static');
        </script>
        @endsection
