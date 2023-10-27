<?php

namespace App\Enums;

enum OrderStatusEnum: string
{
    case UNPAID = 'unpaid';

    case PAID = 'paid';
}
