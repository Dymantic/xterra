<!doctype html>
<html class="" lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', 'XTerra Blog')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="alternate" hreflang="{{ app()->getLocale() === 'en' ? 'zh' : 'en' }}" href="{{ url(transUrl(Request::path())) }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css?family=Barlow+Condensed:500|Source+Sans+Pro:400,400i,600,700|Source+Serif+Pro" rel="stylesheet">

{{--    <link href="https://fonts.googleapis.com/css?family=Barlow+Condensed:500|Source+Sans+Pro:400,600|Source+Serif+Pro" rel="stylesheet">--}}





    <link rel="stylesheet" href="{{ mix('css/front.css') }}">

    @yield('head')

</head>

<body class="pt-16 font-body leading-relaxed {{ $bodyClasses ?? '' }} antialiased">
<!--[if lte IE 9]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="https://browsehappy.com/">upgrade your browser</a> to improve your experience and security.</p>
<![endif]-->
<div id="app">
    @yield('content')
    @include('front.partials.footer')
    @include('front.partials.navbar')
</div>
@yield('bodyscripts')
<script>
    window.fbAsyncInit = function() {
        FB.init({
            appId      : '2393864114037889',
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
