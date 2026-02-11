<?php

declare(strict_types=1);

namespace App\PricingBundle\Repository;

interface CategoryPricingRepository
{
    public function getBasePriceForCategory(string $category): float;
}
