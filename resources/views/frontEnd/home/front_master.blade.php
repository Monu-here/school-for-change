<?php
    $links = App\SmCustomLink::find(1);
    $setting = App\SmGeneralSettings::find(1);
    if (isset($setting->copyright_text)) {
        $copyright_text = $setting->copyright_text;
    } else {
        $copyright_text = 'Copyright © 2019 All rights reserved | This template is made with by Codethemes';
    }
    if (isset($setting->logo)) {
        $logo = $setting->logo;
    } else {
        $logo = 'public/uploads/settings/logo.png';
    }
    if (isset($setting->site_title) && !empty($setting->site_title)) {
        $site_title = $setting->site_title;
    } else {
        $site_title = 'Infix Edu ERP';
    }

    if (isset($setting->favicon)) {
        $favicon = $setting->favicon;
    } else {
        $favicon = 'public/backEnd/img/favicon.png';
    }


    $permisions = App\SmFrontendPersmission::where([['parent_id', 1], ['is_published', 1]])->get();
    $per = [];
    foreach ($permisions as $permision) {
        $per[$permision->name] = 1;
    }

    $ttl_rtl = $setting->ttl_rtl;
    $active_style = App\SmStyle::where('is_active', 1)->first();
?>

        <!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" @if(isset ($ttl_rtl ) && $ttl_rtl ==1) dir="rtl" class="rtl" @endif >

<head>
    <meta charset="utf-8"/>
    <meta name="viewport"
          content="Need Smart School is 100+ unique feature enable school management software system. It can manage all type of school, academy and any educational institution"/>
    <link rel="icon" href="{{asset($favicon)}}" type="image/png"/>
    <title>{{ isset($page_title)? $page_title:$site_title }}</title>
    <meta name="_token" content="{!! csrf_token() !!}"/>
    <!-- Bootstrap CSS -->
    @if(isset ($ttl_rtl ) && $ttl_rtl ==1)
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/css/rtl/bootstrap.min.css"/>
    @else
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/bootstrap.css"/>
    @endif


    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/jquery-ui.css"/>


    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/bootstrap-datepicker.min.css"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/bootstrap-datetimepicker.min.css"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/themify-icons.css"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/font-awesome.min.css"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/nice-select.css"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/magnific-popup.css"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/fastselect.min.css"/>
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/owl.carousel.min.css"/>
    <!-- main css -->


    @if(isset ($ttl_rtl ) && $ttl_rtl ==1)
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/css/rtl/style.css"/>
    @else
        <link rel="stylesheet" href="{{asset('public/backEnd/')}}/css/{{@$active_style->path_main_style}}"/>
    @endif

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <link rel="stylesheet" href="{{asset('public/backEnd/')}}/vendors/css/fullcalendar.min.css">
    <link rel="stylesheet" media="print"
          href="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.print.css">


</head>

<body class="client light">

<!--================ Start Header Menu Area =================-->
<header class="header-area">
    <div class="main_menu">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="container box-1420">
                <!-- Brand and toggle get grouped for better mobile display -->
                <a class="navbar-brand" href="{{url('/')}}/home">
                    <img class="w-75" src="{{asset($logo)}}" alt="Infix Logo" style="max-width: 150px;">
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="ti-menu"></span>
                </button>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse offset" id="navbarSupportedContent">
                    <ul class="nav navbar-nav menu_nav ml-auto">
                        <li class="nav-item  {{Request::path() == '/' ||  Request::path() == 'home'? 'active':''}} "><a
                                    class="nav-link" href="{{url('/')}}/home">Home</a></li>
                        <li class="nav-item {{Request::path() == 'about'? 'active':''}}"><a class="nav-link"
                                                                                            href="{{url('/')}}/about">About</a>
                        </li>
                        <li class="nav-item {{Request::path() == 'course'? 'active':''}}"><a class="nav-link"
                                                                                             href="{{url('/')}}/course">Course</a>
                        </li>
                        <li class="nav-item {{Request::path() == 'news-page'? 'active':''}}"><a class="nav-link"
                                                                                                href="{{url('/')}}/news-page">News</a>
                        </li>
                        <li class="nav-item {{Request::path() == 'contact'? 'active':''}}"><a class="nav-link"
                                                                                              href="{{url('/')}}/contact">Contact</a>
                        </li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <ul class="nav navbar-nav mr-auto search-bar">
                            <li class="">
                               
                            </li>
                        </ul>
                    </ul>
                </div>
            </div>
        </nav>
    </div>
</header>
<!--================ End Header Menu Area =================-->
@yield('main_content')

<!--================Footer Area =================-->
<footer class="footer_area section-gap-top">
    <div class="container">
        <div class="row footer_inner">
            @if(isset($per["Custom Links"]))
                @php
                    $url[1]=[1,2,3,4];
                    $url[2]=[5,6,7,8];
                    $url[3]=[9,10,11,12];
                    $url[4]=[13,14,15,16];
                    for($i=1; $i<=4; $i++){
                     $title ='title'.$i ;
                @endphp
                <div class="col-lg-3 col-sm-6">
                    <aside class="f_widget ab_widget">
                        <div class="f_title">
                            <h4>{{$links!=""?$links->$title:''}}</h4>
                        </div>
                        <ul>
                            @php
                                foreach($url[$i] as $j){
                                    $link_label ='link_label'.$j ;
                                    $link_href ='link_href'.$j ;
                            @endphp
                            <li>
                                <a href="{{$links !="" ? $links->$link_href:''}}"
                                   style="color: #828bb2"> {{$links !="" ? $links->$link_label:''}} </a>
                            </li>
                            @php } @endphp
                        </ul>
                    </aside>
                </div>
                @php } @endphp
            @endif

        </div>
        <div class="row single-footer-widget">
            <div class="col-lg-8 col-md-9">
                <div class="copy_right_text">
                    <p>{!! $copyright_text !!}</p>
                </div>
            </div>

            @if(isset($per["Social Icons"]))
                <div class="col-lg-4 col-md-3">
                    <div class="social_widget">
                        <a href="{{@$links->facebook_url}}"><i class="fa fa-facebook"></i></a>
                        <a href="{{@$links->twitter_url}}"><i class="fa fa-twitter"></i></a>
                        <a href="{{@$links->dribble_url}}"><i class="fa fa-dribbble"></i></a>
                        <a href="{{@$links->linkedin_url}}"><i class="fa fa-linkedin"></i></a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</footer>
<!--================End Footer Area =================-->

<script src="{{asset('public/backEnd/')}}/vendors/js/jquery-3.2.1.min.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/jquery-ui.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/popper.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/bootstrap.min.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/nice-select.min.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/jquery.magnific-popup.min.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/raphael-min.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/morris.min.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/owl.carousel.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.2/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js">
</script>
<script src="{{asset('public/backEnd/')}}/vendors/js/bootstrap-datepicker.min.js"></script>
<!-- <script src="{{asset('public/backEnd/')}}/js/gmap3.min.js"></script> -->
<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCwzmSafhk_bBIdIy7MjwVIAVU1MgUmXY4"></script> -->

<script src="https://maps.googleapis.com/maps/api/js?libraries=places&key=AIzaSyDs3mrTgrYd6_hJS50x4Sha1lPtS2T-_JA"></script>
<script src="{{asset('public/backEnd/')}}/js/main.js"></script>
<script src="{{asset('public/backEnd/')}}/js/custom.js"></script>
<script src="{{asset('public/backEnd/')}}/js/developer.js"></script>

@yield('script')

</body>
</html>

