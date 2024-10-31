<?php

namespace App\Domain\Bus;

use App\Domain\DTO\DeleteRevisionableDTO;

interface DeleteRevisionableBusInterface
{
    /**
     * @param DeleteRevisionableDTO $deleteRevisionableDTO
     *
     * @return void
     */
    public function sendDeleteRevisionableMessage(DeleteRevisionableDTO $deleteRevisionableDTO): void;
}
