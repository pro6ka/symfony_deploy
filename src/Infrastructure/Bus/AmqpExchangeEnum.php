<?php

namespace App\Infrastructure\Bus;

enum AmqpExchangeEnum: string
{
    case START_WORKSHOP = 'start_workshop';
}
