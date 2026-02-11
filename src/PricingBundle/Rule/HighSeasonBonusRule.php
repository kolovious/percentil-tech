<?php

declare(strict_types=1);

namespace App\PricingBundle\Rule;

final class HighSeasonBonusRule implements ValuationRule
{
    private const HIGH_SEASON_MONTHS = [9, 10, 11, 12];
    private const BONUS_AMOUNT = 3.0;

    public function shouldApply(array $context): bool
    {
        $month = (int) date('n');

        return \in_array($month, self::HIGH_SEASON_MONTHS, true);
    }

    public function apply(float $currentPrice, array $context): float
    {
        return $currentPrice + self::BONUS_AMOUNT;
    }
}
