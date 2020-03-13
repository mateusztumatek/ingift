<footer>
    <div class="give-me-space">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    {{--<newsletter></newsletter>--}}
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <img src="{{url('/storage/'.setting('site.logo_white'))}}" style="max-width: 120px" class="mb-3">
                    {!! setting('site.footer') !!}
                </div>
                <div class="col-md-8 d-flex" style="align-items: center">
                    {{menu('footer')}}
                </div>
            </div>
        </div>
    </div>
</footer>
