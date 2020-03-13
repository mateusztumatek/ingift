@php
    $categories = \App\Services\AppService::getCategories();
@endphp
<header-component :categories_parent="{{json_encode($categories)}}"></header-component>
{{--SEO HEADER--}}

<div style="opacity: 0; max-height: 1px; position: fixed; left: -100vw">
    <img alt="Ideacap Logo" src="{{url('/')}}">
</div>
{{--END SEO HEADER--}}
