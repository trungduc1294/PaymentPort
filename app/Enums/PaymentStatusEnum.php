<?php

namespace App\Enums;

enum PaymentStatusEnum: int
{
    case NEW = 0;
    case SELECTED_PAYMENT_GATEWAY = 1;
    case PAYMENT_SUCCESS = 2;

    case PENDING = 3;

    case TRANSACTION_NOT_FOUND = -2;

    case CANCELLED = -1;

    case ERROR = -9;

}
