<?php

declare(strict_types=1);

namespace App\PricingBundle\Rule;

final class HighSeasonBonusRule implements ValuationRule
{
    private const HIGH_SEASON_MONTHS = [9, 10, 11, 12];
    private const BONUS_AMOUNT = 3.0;
    /** @var int */
    private $currentMonth;

    public function __construct(?int $currentMonth = null)
    {
        $this->currentMonth = $currentMonth ?: (int) date('n');
    }

    public function shouldApply(array $context): bool
    {
        return \in_array($this->currentMonth, self::HIGH_SEASON_MONTHS, true);
    }

    public function apply(float $currentPrice, array $context): float
    {
        return $currentPrice + self::BONUS_AMOUNT;
    }
}
