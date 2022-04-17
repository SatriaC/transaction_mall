<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class DateTimeFormatter
{
    public static function duration($fromDateTime, $toDateTime)
    {
        $from = Carbon::parse($fromDateTime);
        if ($toDateTime == null) {
            $to = Carbon::now();
        } else {
            $to = Carbon::parse($toDateTime);
        }
        return static::durationDiff($from, $to);
    }

    private static function durationDiff($from, $to)
    {
        $totalDuration = $to->diffInSeconds($from);
        $totalDuration = static::formatting($totalDuration);
        return $totalDuration;
    }

    private static function formatting($totalDuration)
    {
        $duration = gmdate("z:H:i:s", $totalDuration);
        $splitDuration = explode(":", $duration);
        $strDuration = "";
        if ($splitDuration[0] != 0) {
            $strDuration = $strDuration . '' . $splitDuration[0] . 'day ';
        }

        if ($splitDuration[1] != "00") {
            $strDuration = $strDuration . $splitDuration[1] . 'hrs ';
        }

        if ($splitDuration[2] != "00") {
            $strDuration = $strDuration . $splitDuration[2] . 'min ';
        }

        $strDuration = $strDuration . $splitDuration[3] . 'sec';
        return $strDuration;
    }

    public static function getIsoFormat($dateTime)
    {
        $date = Carbon::createFromIsoFormat(config('app.iso_format'), $dateTime);
        return $date->isoFormat(config('app.to_iso_format'));
    }

    public static function getTimestamp($dateTime)
    {
        $date = Carbon::parse($dateTime);
        return $date->timestamp;
    }
}
