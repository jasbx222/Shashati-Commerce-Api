<?php

namespace App\Enums;

class AdsType
{
    const BANNER = 'banner';
    const SLIDER = 'slider';
    const LAST = 'last';

    /**
     *@var array
     */ 
    const SET = [
        self::BANNER, 
        self::SLIDER,  
        self::LAST,  
    ];
}
