<?php

namespace backend\modules\user\helpers;

use Carbon\Carbon;

class DateFormat
{
    public static function forSave($date)
    {
        if($date){
            return Carbon::createFromFormat('d/m/Y',$date)->format('Y-m-d');
        }
    }

    public static function forView($date)
    {
        if($date){
            return Carbon::createFromFormat('Y-m-d',$date)->format('d/m/Y');
        }
    }

    public static function viewTimestamp($timestamp)
    {
        if($timestamp){
            return Carbon::createFromTimestamp($timestamp)->format('d/m/Y H:i:s');
        }
    }


    //For NewsLetter
    public static function viewNewsLetterEdit($timestamp)
    {
        if($timestamp){
            return Carbon::createFromTimestamp($timestamp)->format('d.m.Y H:i');
        }
    }

    public static function viewTimestampDate($timestamp,$separator='slash')
    {
        if($timestamp){
            switch ($separator){
                case 'slash':
                    return Carbon::createFromTimestamp($timestamp)->format('d/m/Y');
                    break;
                case 'dot':
                    return Carbon::createFromTimestamp($timestamp)->format('d.m.Y');
                    break;
                case 'dash':
                    return Carbon::createFromTimestamp($timestamp)->format('d-m-Y');
                    break;
                default:
                    return Carbon::createFromTimestamp($timestamp)->format('d/m/Y');
            }
        }
    }

    public static function convertTimestamp($date)
    {
        return Carbon::parse(Carbon::createFromFormat('d/m/Y',$date)->format('Y-m-d'))->timestamp;
    }

}