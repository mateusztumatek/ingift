
@php
    $fonts = \App\Font::all();

    foreach ($fonts as $font){
       $font->url = url('/storage/'.$font->url);
    }
@endphp

<script>
    var fonts = JSON.parse('{!! json_encode($fonts) !!}');
    fonts.forEach((item) => {
        var junction_font = new FontFace(item.font_family, "url("+item.url+")");
        junction_font.load().then(function(loaded_face) {
            document.fonts.add(loaded_face);
        })
    });
</script>
