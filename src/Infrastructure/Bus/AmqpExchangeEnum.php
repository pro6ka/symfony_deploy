<?php

namespace App\Infrastructure\Bus;

enum AmqpExchangeEnum: string
{
    case START_WORKSHOP = 'start_workshop';
    case DELETE_ANSWER = 'delete_answer';
}
