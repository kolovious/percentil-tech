<?php

declare(strict_types=1);

namespace App\Tests\PricingBundle\Rule;

use App\PricingBundle\Rule\FranceCountryBoostRule;
use PHPUnit\Framework\TestCase;

final class FranceCountryBoostRuleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldApplyReturnsTrueForFranceCountry(): void
    {
        $rule = new FranceCountryBoostRule();

        self::assertTrue($rule->shouldApply(['country' => 'FR']));
        self::assertTrue($rule->shouldApply(['country' => 'fr']));
    }

    /**
     * @test
     */
    public function shouldApplyReturnsFalseForOtherCountries(): void
    {
        $rule = new FranceCountryBoostRule();

        self::assertFalse($rule->shouldApply(['country' => 'ES']));
        self::assertFalse($rule->shouldApply([]));
    }

    /**
     * @test
     */
    public function applyIncreasesPriceByTwentyPercent(): void
    {
        $rule = new FranceCountryBoostRule();

        self::assertSame(24.0, $rule->apply(20.0, ['country' => 'FR']));
    }
}
