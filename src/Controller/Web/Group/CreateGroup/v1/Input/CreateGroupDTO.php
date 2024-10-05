<?php

namespace App\Controller\Web\Group\CreateGroup\v1\Input;

use App\Domain\Model\Group\CreateGroupModel;
use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateGroupDTO
{
    /**
     * @param string $name
     * @param bool $isActive
     * @param null|string $workingFrom
     * @param null|string $workingTo
     */
    public function __construct(
        #[Assert\Length(min: 1, max: 32)]
        public string $name,
        #[Assert\Type('boolean')]
        public bool $isActive = false,
        #[Assert\DateTime(format: CreateGroupModel::WORKING_FROM_FORMAT)]
        #[Assert\NotBlank(allowNull: true)]
        public ?string $workingFrom = null,
        #[Assert\DateTime(format: CreateGroupModel::WORKING_FROM_FORMAT)]
        #[Assert\NotBlank(allowNull: true)]
        public ?string $workingTo = null
    ) {
    }
}
