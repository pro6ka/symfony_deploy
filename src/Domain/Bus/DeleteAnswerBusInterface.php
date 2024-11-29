<?php

namespace App\Domain\Bus;

interface DeleteAnswerBusInterface
{
    /**
     * @param int $answerId
     *
     * @return void
     */
    public function sendDeleteAnswerMessage(int $answerId): void;
}
