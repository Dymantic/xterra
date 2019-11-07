<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    @section('title')
        <title>XTERRA | Admin </title>
    @show
    <link rel="stylesheet"
          href="{{ mix('css/app.css') }}"/>
    <meta id="csrf-token-meta"
          name="csrf-token"
          content="{{ csrf_token() }}">
    <META NAME="ROBOTS"
          CONTENT="NOINDEX, NOFOLLOW">
    @yield('head')
</head>
<body class="{{ $pageClasses ?? '' }} text-gray-800 font-sans bg-gray-100">
<div id="app">
    <navbar></navbar>
    <router-view></router-view>
    <notification-hub></notification-hub>
</div>

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
