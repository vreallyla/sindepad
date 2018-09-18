@extends ('layouts/mst_user')
@section('desc','rahasia')
@section('key','anu')
@section('content')
<!--Breadcrumb start-->
<div class="ed_pagetitle" data-stellar-background-ratio="0.5" data-stellar-vertical-offset="0" style="background-image: url(http://placehold.it/921X533);">
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
                    <li><a href="{{route('about')}}">{{$menu}}</a></li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!--Breadcrumb end-->
<!--chart section start -->
<div class="ed_graysection ed_toppadder90 ed_bottompadder90">
    <div class="container">
        <div class="row">
            <div class="ed_counter_wrapper">
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="ed_chart_ratio">
                        <i class="fa fa-line-chart"></i>
                        <h4>Officially the best</h4>
                        <p>Just in case there is anyone looking for it,we added new expertise to our knowledge base to make you happy.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="ed_chart_ratio">
                        <i class="fa fa-sliders"></i>
                        <h4>Redesigned website</h4>
                        <p>A wonderful serenity has taken possession of my entire soul of spring which I enjoy with my whole heart.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="ed_chart_ratio">
                        <i class="fa fa-folder-open-o"></i>
                        <h4>We are launching</h4>
                        <p>Incapable of drawing a single stroke at the present moment; and yet I feel that I never was a greater artist.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- chart Section end -->
<!-- team member section start -->
<div class="ed_transprentbg ed_toppadder80 ed_bottompadder80">
    <div class="container">
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="ed_team_member">
                <div class="ed_team_member_img">
                    <img src="http://placehold.it/255X255" alt="item1" class="img-responsive">
                </div>
                <div class="ed_team_member_description">
                    <h4><a href="instructor_dashboard.html">Andre House</a></h4>
                    <h5>director</h5>
                    <p>Project-Based Learning is a flexible tool for framing.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="ed_team_member">
                <div class="ed_team_member_img">
                    <img src="http://placehold.it/255X255" alt="item2" class="img-responsive">
                </div>
                <div class="ed_team_member_description">
                    <h4><a href="instructor_dashboard.html">Frank Pascole</a></h4>
                    <h5>principle</h5>
                    <p>The European languages are members of the same fam.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="ed_team_member">
                <div class="ed_team_member_img">
                    <img src="http://placehold.it/255X255" alt="item3" class="img-responsive">
                </div>
                <div class="ed_team_member_description">
                    <h4><a href="instructor_dashboard.html">Tina Bonucci</a></h4>
                    <h5>t.p.o.</h5>
                    <p> The languages only differ in grammar, common words.</p>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="ed_team_member">
                <div class="ed_team_member_img">
                    <img src="http://placehold.it/255X255" alt="item4" class="img-responsive">
                </div>
                <div class="ed_team_member_description">
                    <h4><a href="instructor_dashboard.html">Shy Tommus</a></h4>
                    <h5>h.o.d.</h5>
                    <p>If several languages coalesce, the grammar of the resulting language.</p>
                </div>
            </div>
        </div>
    </div><!-- /.container -->
</div>
<!-- team member section end -->
<!--counter section start -->
<div class="ed_graysection ed_toppadder90 ed_bottompadder90">
    <div class="container">
        <div class="ed_counter_wrapper">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="ed_counter">
                    <h2 class="timer" data-from="0" data-to="2600" data-speed="3000"></h2>
                    <h4>Students graduated</h4>
                    <p>Throughout these year we have done amazing work with 250 students..</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="ed_counter">
                    <h2 class="timer" data-from="0" data-to="5900" data-speed="3000"></h2>
                    <h4>Competitions won</h4>
                    <p>Only competitions were the ones in the back of the magazines you find..</p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                <div class="ed_counter">
                    <h2 class="timer" data-from="0" data-to="8400" data-speed="3000"></h2>
                    <h4>Classes visited</h4>
                    <p>Can how you setup your classroom impact how students think...</p>
                </div>
            </div>
        </div>
    </div>
</div>
<!--counter section end -->
@endsection