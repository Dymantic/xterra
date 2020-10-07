<!doctype html>
<html class="h-full" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'XTERRA TAIWAN')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="alternate" hreflang="{{ app()->getLocale() === 'en' ? 'zh' : 'en' }}" href="{{ url(transUrl(Request::path())) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

{{--    <link href="https://fonts.googleapis.com/css?family=Barlow+Condensed:500|Source+Sans+Pro:400,400i,600,700|Source+Serif+Pro" rel="stylesheet">--}}

    <link href="https://fonts.googleapis.com/css?family=Barlow+Condensed:500|Source+Sans+Pro:400,600|Source+Serif+Pro" rel="stylesheet">





    <link rel="stylesheet" href="{{ mix('css/front.css') }}">

    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#2e2d2f">

    @yield('head')

<!-- Google Tag Manager -->

    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start': new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0], j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src='https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);})(window,document,'script','dataLayer','{{ config('services.google.tag_manager_code') }}');
    </script>

    <!-- End Google Tag Manager -->

</head>

<body class="h-full pt-16 font-body leading-relaxed {{ $bodyClasses ?? '' }} antialiased">
<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-PRWNH4X" height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
<div id="app" class="h-full flex flex-col">
    <div class="flex-1">
        @yield('content')
    </div>

    @include('front.partials.footer')
    @include('front.partials.navbar')
</div>
@yield('bodyscripts')
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      :  {{ config('services.facebook.app_id') }},
            cookie     : true,
            xfbml      : true,
            version    : 'v4.0'
        });

        FB.AppEvents.logPageView();

    };

    (function(d, s, id){
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) {return;}
        js = d.createElement(s); js.id = id;
        js.src = "https://connect.facebook.net/en_US/sdk.js";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));
</script>
<script src="{{ mix("js/front.js") }}"></script>
<script>
    window.ga = function () { ga.q.push(arguments) }; ga.q = []; ga.l = +new Date;
    ga('create', '{{ config('services.google.analytics_id') }}', 'auto'); ga('send', 'pageview')
</script>
<script src="https://www.google-analytics.com/analytics.js" async defer></script>
</body>

</html>
