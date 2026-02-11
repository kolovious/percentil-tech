<?php

declare(strict_types=1);

namespace App\Tests\PricingBundle\Rule;

use App\PricingBundle\Rule\BrandBoostRule;
use PHPUnit\Framework\TestCase;

final class BrandBoostRuleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldApplyReturnsTrueForZara(): void
    {
        $rule = new BrandBoostRule();

        self::assertTrue($rule->shouldApply(['brand' => 'Zara']));
        self::assertTrue($rule->shouldApply(['brand' => 'zArA']));
    }

    /**
     * @test
     */
    public function shouldApplyReturnsFalseForOtherBrands(): void
    {
        $rule = new BrandBoostRule();

        self::assertFalse($rule->shouldApply(['brand' => 'Mango']));
        self::assertFalse($rule->shouldApply([]));
    }

    /**
     * @test
     */
    public function applyAddsTenPercentToCurrentPrice(): void
    {
        $rule = new BrandBoostRule();

        self::assertSame(22.0, $rule->apply(20.0, []));
    }
}
