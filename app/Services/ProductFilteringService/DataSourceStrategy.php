<?php

namespace App\Services\ProductFilteringService;

interface DataSourceStrategy
{
    public function fetchAndFilterData(): array;
}
