<?php

namespace App\Enum;

class Status
{
    const DELETE = 1;
    const ACTIVE = 2;
    const PASSIVE = 3;
    const CLOSED = 4;
    
    public static array $statusList = [
        self::DELETE => 'Delete',
        self::ACTIVE => 'Active',
        self::PASSIVE => 'Passive',
        self::CLOSED => 'Closed',
    ];
}