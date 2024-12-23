<?php

namespace App\Controller\Web\Workshop\ListWorkshop\v1\Output\Part;

readonly class ListWorkshopItemDTO
{
    /**
     * @param int $id
     * @param string $title
     * @param string $description
     * @param ListWorkshopAuthorDTO $author
     */
    public function __construct(
        public int $id,
        public string $title,
        public string $description,
        public ListWorkshopAuthorDTO $author
    ) {
    }
}
