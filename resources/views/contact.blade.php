@extends ('layouts/mst_user')
@section('desc','rahasia')
@section('key','anu')
@section('content')
    <!--Breadcrumb start-->
    <div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0"
         style="background-image: url({{$parralax}});">
        <div class="ed_img_overlay"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-4 col-sm-6">
                    <div class="page_title">
                        <h2>{{$title}}</h2>
                    </div>
                </div>
                <div class="col-lg-6 col-md-8 col-sm-6">
                    <ul class="breadcrumb">
                        <li><a href="{{route('welcome')}}">Beranda</a></li>
                        <li><i class="fa fa-chevron-left"></i></li>
                        <li><a href="{{route('contact')}}">{{$menu}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <!--Breadcrumb end-->
    <!--Section fourteen Contact form start-->
    <div class="ed_transprentbg ed_toppadder80 ed_bottompadder80">
        <div class="container">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="ed_heading_top">
                        <h3>Send us a message</h3>
                    </div>
                </div>
                <div class="ed_contact_form ed_toppadder60">
                    <form class="form form-feedback" action="{{route('api.sendFeedback')}}" method="POST">
                        {{csrf_field()}}
                        <div class="col-lg-6 col-md-6 col-sm-12">

                            <div class="form-group">
                                <input type="text" id="uname" name="uname" class="form-control" placeholder="Your Name">
                            </div>
                            <div class="form-group">
                                <input type="email" id="umail" name="umail" class="form-control"
                                       placeholder="Your Email">
                            </div>
                            <div class="form-group">
                                <input type="text" id="sub" name="sub" class="form-control" placeholder="Subject">
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12">
                            <div class="form-group">
                                <textarea id="msg" name="msg" class="form-control" rows="6"
                                          placeholder="Message"></textarea>
                            </div>
                            <button type="submit" id="ed_submit" class="btn ed_btn ed_orange pull-right round-swall">
                                send
                            </button>
                            <p id="err"></p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--Section fourteen Contact form start-->
    <!--Section fifteen Contact form start-->
    <div class="ed_event_single_contact_address ed_toppadder70 ed_bottompadder70">
        <div class="container">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="ed_heading_top ed_bottompadder70">
                    <h3>Contact & Find</h3>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="row">
                    <div class="ed_event_single_address_info ed_toppadder50 ed_bottompadder50">
                        <h4 class="ed_bottompadder30">contact info</h4>
                        <p class="ed_bottompadder40 ed_toppadder10">You can always reach us via following contact
                            details. We will give our best to reach you as possible.</p>
                        <a href="tel:{{$default[0]->phone}}" style="cursor: pointer"><p>Phone: <span
                                        class="phone">{{$default[0]->phone}}</span></p></a>
                        <p>Email: <a href="#">info@edutioncollege.gov.co.uk</a></p>
                        <p>Website: <a href="#">http://www.edutioncollege.gov.co.uk</a></p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <div class="row">
                    <div class="ed_event_single_address_map">
                        <div id="map"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('package')
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCV5kHOOjqTQtyBQYSHT-KXfKLxo9GmjWk&callback=initMap&sensor=true"
            async defer></script>
    <script type="text/javascript" src="js/gmaps.js"></script>
@endpush
@push('js')
    <script>
        var map;
        $(document).ready(function () {
            map = new GMaps({
                el: '#map',
                zoom: 16,
                lat: -12.043333,
                lng: -77.028333,
                scrollwheel: false,
                draggable: false,
                zoomControl: false,
                navigationControl: false,
                mapTypeControl: false,
                scaleControl: false,
                disableDoubleClickZoom: true,
                streetViewControl: false,
                overviewMapControl: false,
                panControl: false
            });

        });

    </script>
@endpush