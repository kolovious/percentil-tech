<?php

declare(strict_types=1);

namespace App\PricingBundle\Rule;

final class ConditionMultiplierRule implements ValuationRule
{
    /** @var array<string, float> */
    private $multipliersByCondition = [
        'new' => 1.5,
        'good' => 1.2,
        'fair' => 1.0,
    ];

    public function shouldApply(array $context): bool
    {
        $condition = strtolower(trim((string) ($context['condition'] ?? '')));

        return isset($this->multipliersByCondition[$condition]);
    }

    public function apply(float $currentPrice, array $context): float
    {
        $condition = strtolower(trim((string) ($context['condition'] ?? '')));
        $multiplier = $this->multipliersByCondition[$condition];

        return $currentPrice * $multiplier;
    }
}
