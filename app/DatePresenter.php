<?php


namespace App;


use Illuminate\Support\Carbon;

class DatePresenter
{
    const STANDARD = 'Y-m-d';
    const PRETTY = 'Y.m.d';

    public static function standard($date): string
    {
        if(!$date || !$date instanceof Carbon) {
            return '';
        }

        return $date->format(self::STANDARD);
    }

    public static function pretty($date): string
    {
        if(!$date || !$date instanceof Carbon) {
            return '';
        }

        return $date->format(self::PRETTY);
    }

    public static function range(?Carbon $from, ?Carbon $to, $separator = '-')
    {
        if(!$from || !$to) {
            return '';
        }

        if($from->isSameDay($to)) {
            return self::pretty($from);
        }

        if(($from->year === $to->year) && ($from->month === $to->month)) {
            return sprintf("%s %s %s", $from->format("Y.m.d"), $separator, $to->format("d"));
        }

        if(($from->year === $to->year) && ($from->month !== $to->month)) {
            return sprintf("%s %s %s", $from->format("Y.m.d"), $separator, $to->format("m.d"));
        }

        return sprintf("%s %s %s", $from->format("Y.m.d"), $separator, $to->format("Y.m.d"));

    }
}
