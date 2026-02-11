<?php

declare(strict_types=1);

namespace App\Tests\PricingBundle\Rule;

use App\PricingBundle\Rule\HighSeasonBonusRule;
use PHPUnit\Framework\TestCase;

final class HighSeasonBonusRuleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldApplyReturnsTrueDuringHighSeason(): void
    {
        $rule = new HighSeasonBonusRule(10);

        self::assertTrue($rule->shouldApply([]));
    }

    /**
     * @test
     */
    public function shouldApplyReturnsFalseOutsideHighSeason(): void
    {
        $rule = new HighSeasonBonusRule(2);

        self::assertFalse($rule->shouldApply([]));
    }

    /**
     * @test
     */
    public function applyAddsConfiguredBonusAmount(): void
    {
        $rule = new HighSeasonBonusRule();

        self::assertSame(23.0, $rule->apply(20.0, []));
    }
}
