<?php

namespace App\Controller\Web\Question\ListQuestion\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use App\Controller\Web\Question\ListQuestion\v1\Output\Part\ListQuestionItemDTO;
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
