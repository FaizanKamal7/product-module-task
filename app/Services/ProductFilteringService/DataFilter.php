<?php

namespace App\Services\ProductFilteringService;

use App\Services\ProductFilteringService\DataSourceStrategy;

class DataFilter
{
    private DataSourceStrategy $strategy;

    public function setStrategy(DataSourceStrategy $strategy): void
    {
        $this->strategy = $strategy;
    }

    public function execute(): array
    {
        return $this->strategy->fetchAndFilterData();
    }
}
