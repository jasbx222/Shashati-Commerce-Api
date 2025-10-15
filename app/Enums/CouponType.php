<?php

namespace App\Enums;

class CouponType
{
    const FIXED = 'fixed';
    const PERCENTAGE = 'percentage';

    const SET = [
        self::FIXED,
        self::PERCENTAGE
    ];
}