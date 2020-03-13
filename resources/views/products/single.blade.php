@extends('layouts.app')
@section('content')
    <div class="row product">
        <div class="col-md-6 pa-0">
            <div class="sticky" :style="{'height': ($vuetify.breakpoint.smAndDown)? 'unset' : '100vh', 'max-height': ($vuetify.breakpoint.smAndDown)? '80vh' : null}" style="overflow: hidden" id="preview">
                <v-carousel
                        v-cloak
                        cycle
                        height="100%"
                        hide-delimiter-background
                        show-arrows-on-hover>
                    @foreach($product->getModel()->all_images as $key => $image)
                        <v-carousel-item key="{{$key}}"><img style="object-fit: cover" height="100%" width="100%" src="{{url('/storage/'.$image)}}"></v-carousel-item>
                    @endforeach
                </v-carousel>
                <v-img v-cloak width="100%" height="100%" style="position: absolute; left: 0px; top: 0px; z-index: 1" cover :src="$product.generated.data" v-if="$product.generated.show">
                    <div class="pa-3 d-flex justify-end align-end" style="height: 100%">
                        <v-btn @click="$product.downloadPreview()" color="primary" class="my-btn mr-2" :height="($vuetify.breakpoint.smAndDown)? '40px' : '60px'"><v-icon>mdi-download</v-icon>Zapisz</v-btn>
                        <v-btn @click="$product.generated.show = false" color="primary" class="my-btn" :height="($vuetify.breakpoint.smAndDown)? '40px' : '60px'">Zamknij podgląd</v-btn>
                    </div>
                </v-img>
            </div>
        </div>
        <div v-cloak class="col-md-6 d-flex align-center" :style="{'padding-top': ($vuetify.breakpoint.smAndUp)? '100px' : null}">
            <div class="col-lg-8 col-md-10 col-sm-12 ma-auto">
                <div class="mt-5">
                    @php
                        $main_categories = $product->categories->where('parent_id', null)->values();
                    @endphp
                    @foreach($main_categories as $key => $c)
                        <a class="my-link text-muted" href="{{$c->getLink()}}">{{$c->name}} @if($key + 1 != count($main_categories))<span class="mx-2"> / </span>@endif</a>
                        @endforeach
                    <h1 class="header">{{$product->name}}</h1>
                    <v-chip-group column active-class="primary--text">
                        @foreach($product->tags as $tag)
                        <v-chip active-class="" color="primary" small dark>{{$tag->tag}}</v-chip>
                            @endforeach
                    </v-chip-group>
                    <div class="d-flex flex-wrap align-center my-4">
                        <v-rating :value="4.5" readonly half-increments></v-rating>
                        <span class="font-weight-bold ml-4">4,5</span>
                        <span class="text-muted ml-2">(15 Reviews)</span>
                    </div>
                    <div>
                        {!! $product->desc !!}
                    </div>
                    <v-divider class="my-5"></v-divider>
                    @if(count($attributes) > 0)
                    <div>
                        <p>Wybierz warianty</p>
                        @foreach($attributes ?? '' as $group)
                            @if($group[0]->attribute->type == 'text' && count($group) > 1)
                                <v-select dense @change="log()" label="{{$group[0]->attribute->name}}" item-text="value" item-value="value" v-model="$product.product.variants[{{$group[0]->attribute->id}}]" :items="{{$group}}"></v-select>
                            @elseif($group[0]->attribute->type == 'color' && count($group) > 1)
                                <color-select class="my-3" :colors="{{json_encode($group)}}"></color-select>
                                @endif
                            @endforeach
                    </div>
                        <v-divider class="my-5"></v-divider>
                    @endif
                    @if($product->is_customizable)
                    <div class="mb-4">
                        <h3 class="mb-3 text-muted">Personalizuj produkt: </h3>
                            <div v-for="field in $product.preview" >
                                <v-text-field v-model="field.text" v-if="field.type == 'text'" :rules="[validation.required]" class="no-validation my-4" outlined :label="field.field_name"></v-text-field>
                                <image-uploader class="my-2" v-model="field.image_src" v-if="field.type == 'image'"></image-uploader>
                            </div>
                        <v-btn class="my-btn" color="primary" @click="$product.generatePreview().then(res => {$vuetify.goTo('#preview')})" style="width: 100%" :loading="$product.generating">Generuj podgląd</v-btn>
                    </div>

                        <v-divider></v-divider>


                    @endif
                    <div class="col-lg-6 col-md-8 col-sm-8 px-0 mt-3">
                        <quantity-input v-model="$product.quantity"></quantity-input>
                    </div>
                    <div class="row justify-space-between">
                        <div class="col-lg-6">
                            <div class="d-flex align-end" style="height: 100%">
                                <span class="price">@{{$product.caluclatePrice}} zł</span>
                                @if($product->calculated < $product->price)
                                    <span class="price sellout ml-3">{{$product->price}} zł</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="d-flex justify-end align-center">
                                <v-btn class="my-btn" :class="{'w-100': $vuetify.breakpoint.smAndDown}" style="min-height: 70px; font-size: 1.2rem" color="primary"><v-icon class="mr-3">mdi-plus</v-icon>Dodaj do koszyka</v-btn>
                            </div>
                        </div>
                    </div>
                    <div class="mt-3 mb-6">
                        <v-divider></v-divider>
                    </div>

                    <div class="mt-3">
                        <rate-section id="{{$product->id}}" type="product"></rate-section>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection
    @section('js')
    <script>
        Vue.prototype.$product.set({!! json_encode($product->getModel())!!});
        Vue.prototype.$product.setPreview({!! json_encode($product->getModel()->getCustomizableItems())!!})
        @foreach($attributes ?? '' as $group)
            @if(count($group) == 1)
                Vue.prototype.$product.setDefaultVariant({!! $group[0] !!}, {{$group[0]->attribute->id}});
            @endif
            @endforeach
    </script>
        @endsection
