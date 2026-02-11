<?php

declare(strict_types=1);

namespace App\PricingBundle\Repository;

final class InMemoryCategoryPricingRepository implements CategoryPricingRepository
{
    /** @var array<string, float> */
    private $basePricesByCategory = [
        'dress' => 22.0,
        'jeans' => 20.0,
        'coat' => 35.0,
        'shirt' => 16.0,
        'shoes' => 24.0,
    ];

    public function getBasePriceForCategory(string $category): float
    {
        $normalizedCategory = strtolower(trim($category));

        return $this->basePricesByCategory[$normalizedCategory] ?? 12.0;
    }
}
