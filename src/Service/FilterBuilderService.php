<?php


namespace App\Service;


use App\Manager\FilterManager;
use App\Manager\FilterTypeManager;

class FilterBuilderService
{

    private FilterManager $filterManager;
    private FilterTypeManager $filterTypeManager;

    public function __construct(FilterManager $filterManager, FilterTypeManager $filterTypeManager)
    {

        $this->filterManager = $filterManager;
        $this->filterTypeManager = $filterTypeManager;
    }

    public function createFilterWithType(array $filterData, int $filterTypeData_id)
    {



        $filter = $this->filterManager->create($filterData);



    }

}