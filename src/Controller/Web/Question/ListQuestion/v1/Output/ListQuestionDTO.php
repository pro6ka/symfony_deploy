<?php

namespace App\Controller\Web\Question\ListQuestion\v1\Output\Part;

use App\Controller\DTO\OutputDTOInterface;
use App\Domain\Model\PaginationModel;

readonly class ListQuestionDTO implements OutputDTOInterface
{
    /**
     * @param array $questionList
     * @param PaginationModel $pagination
     */
    public function __construct(
        /** @var ListQuestionItemDTO[] */
        public array $questionList,
        public PaginationModel $pagination
    ) {
    }
}
