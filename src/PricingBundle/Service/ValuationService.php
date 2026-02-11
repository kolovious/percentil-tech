<?php

declare(strict_types=1);

namespace App\PricingBundle\Service;

use App\PricingBundle\Repository\CategoryPricingRepository;
use App\PricingBundle\Rule\ValuationRule;

final class ValuationService
{
    /** @var iterable<ValuationRule> */
    private $rules;
    /** @var CategoryPricingRepository */
    private $categoryPricingRepository;

    /**
     * @param iterable<ValuationRule> $rules
     */
    public function __construct(
        CategoryPricingRepository $categoryPricingRepository,
        iterable $rules
    ) {
        $this->categoryPricingRepository = $categoryPricingRepository;
        $this->rules = $rules;
    }

    /**
     * @return array<string, mixed>
     */
    public function estimate(string $brand, string $category, string $condition): array
    {
        $basePrice = $this->categoryPricingRepository->getBasePriceForCategory($category);

        $context = [
            'brand' => $brand,
            'category' => $category,
            'condition' => $condition,
        ];

        $estimatedPrice = $basePrice;
        foreach ($this->rules as $rule) {
            if (!$rule->shouldApply($context)) {
                continue;
            }

            $estimatedPrice = $rule->apply($estimatedPrice, $context);
        }

        $estimatedPrice = round($estimatedPrice, 2);

        return [
            'brand' => $brand,
            'category' => $category,
            'condition' => $condition,
            'basePrice' => round($basePrice, 2),
            'estimatedPrice' => $estimatedPrice,
            'currency' => 'EUR',
        ];
    }
}
