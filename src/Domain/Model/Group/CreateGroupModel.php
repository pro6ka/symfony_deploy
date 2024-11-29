<?php

namespace App\Domain\Model\Group;

use DateTime;
use Symfony\Component\Validator\Constraints as Assert;

readonly class CreateGroupModel
{
    public const string WORKING_FROM_FORMAT = 'Y-m-d H:i:s';

    /**
     * @param string $name
     * @param bool $isActive
     * @param DateTime $workingFrom
     * @param null|DateTime $workingTo
     */
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 1, max: 32)]
        public string $name,
        #[Assert\Type('boolean')]
        public bool $isActive = false,
        #[Assert\Type('datetime')]
        public DateTime $workingFrom = new DateTime(),
        #[Assert\NotBlank(allowNull: true)]
        public ?DateTime $workingTo = null
    ) {
    }
}
