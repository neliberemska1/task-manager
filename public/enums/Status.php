<?php

namespace App\Enums;

use MyCLabs\Enum\Enum;

class Status extends Enum
{
    const Open = 'Open';
    const InProgress = 'In Progress';
    const Done = 'Done';
}

echo json_encode(Status::toArray());
