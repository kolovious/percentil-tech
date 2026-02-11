<?php

declare(strict_types=1);

namespace App\PricingBundle\Rule;

/**
 * This rule applies a 10% boost to the estimated price if the brand is "Zara".
 */
final class BrandBoostRule implements ValuationRule
{
    public function shouldApply(array $context): bool
    {
        $brand = strtolower(trim((string) ($context['brand'] ?? '')));

        return $brand === 'zara';
    }

    public function apply(float $currentPrice, array $context): float
    {
        return $currentPrice * 1.10;
    }
}
