<?php

namespace App\Enums;

class OrderStatus
{
    // الحالة المعلقة
 const PENDING = 'pending';
    
    // الحالة المقبولة
    const ACCEPTED = 'accepted';
    
    // الحالة المكتملة
    const COMPLETED = 'completed';
    
    // الحالة الملغاة
    const CANCELLED = 'cancelled';
    
    // الحالة المسترجعة
    const RETURNED = 'returned';

    const SET = [
        self::PENDING,
        self::ACCEPTED,
        self::COMPLETED,
        self::CANCELLED,
        self::RETURNED,
    ];
}
