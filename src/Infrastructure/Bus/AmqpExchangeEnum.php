<?php

namespace App\Infrastructure\Bus;

enum AmqpExchangeEnum: string
{
    case WORKSHOP = 'workshop';
    case DELETE_REVISIONABLE = 'delete_revisionable';
}
