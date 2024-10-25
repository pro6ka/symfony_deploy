<?php

namespace App\Infrastructure\Bus;

enum AmqpQueueEnum: string
{
    case START_WORKSHOP = 'start_workshop';
}
