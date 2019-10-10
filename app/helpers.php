<?php

use Illuminate\Support\Str;

function localUrl($url) {
    return sprintf("/%s/%s", app()->getLocale(), ltrim($url, '/'));
}

function transUrl($url) {
    $url = Str::start($url, '/');

    if($url === '/en' || $url === '/zh') {
        $url = $url . '/';
    }
    if(Str::startsWith($url, ['/en/', '/zh/'])) {
        $url = mb_substr($url, 4);
    }


    if(app()->getLocale() === 'en') {
        return '/zh/' . ltrim($url, '/');
    }

    return '/en/' . ltrim($url, '/');
}