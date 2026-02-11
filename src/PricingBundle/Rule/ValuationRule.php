<?php

declare(strict_types=1);

namespace App\PricingBundle\Rule;

interface ValuationRule
{
    /**
     * @param array<string, mixed> $context
     */
    public function shouldApply(array $context): bool;

    /**
     * @param array<string, mixed> $context
     */
    public function apply(float $currentPrice, array $context): float;
}
