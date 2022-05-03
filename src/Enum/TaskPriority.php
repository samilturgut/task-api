<?php

namespace App\Enum;

class TaskPriority
{
    const IMPORTANT = 1;
    const EMERGENCY = 2;
    const NORMAL = 3;
    
    public static array $priorityList = [
        self::IMPORTANT => 'Important',
        self::EMERGENCY => 'Emergency',
        self::NORMAL => 'Normal',
    ];
}