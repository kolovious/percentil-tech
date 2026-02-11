<?php

declare(strict_types=1);

namespace App\PricingBundle\Rule;

final class FranceCountryBoostRule implements ValuationRule
{
    public function shouldApply(array $context): bool
    {
        $country = strtoupper(trim((string) ($context['country'] ?? '')));

        return $country === 'FR';
    }

    public function apply(float $currentPrice, array $context): float
    {
        return $currentPrice * 1.20;
    }
}
