<?php

declare(strict_types=1);

namespace App\Tests\PricingBundle\Rule;

use App\PricingBundle\Rule\ConditionMultiplierRule;
use PHPUnit\Framework\TestCase;

final class ConditionMultiplierRuleTest extends TestCase
{
    /**
     * @test
     */
    public function shouldApplyReturnsTrueForSupportedConditions(): void
    {
        $rule = new ConditionMultiplierRule();

        self::assertTrue($rule->shouldApply(['condition' => 'new']));
        self::assertTrue($rule->shouldApply(['condition' => 'good']));
        self::assertTrue($rule->shouldApply(['condition' => 'fair']));
    }

    /**
     * @test
     */
    public function shouldApplyReturnsFalseForUnsupportedCondition(): void
    {
        $rule = new ConditionMultiplierRule();

        self::assertFalse($rule->shouldApply(['condition' => 'bad']));
        self::assertFalse($rule->shouldApply([]));
    }

    /**
     * @test
     */
    public function applyUsesNewConditionMultiplier(): void
    {
        $rule = new ConditionMultiplierRule();

        self::assertSame(30.0, $rule->apply(20.0, ['condition' => 'new']));
    }

    /**
     * @test
     */
    public function applyUsesGoodConditionMultiplier(): void
    {
        $rule = new ConditionMultiplierRule();

        self::assertSame(24.0, $rule->apply(20.0, ['condition' => 'good']));
    }

    /**
     * @test
     */
    public function applyUsesFairConditionMultiplier(): void
    {
        $rule = new ConditionMultiplierRule();

        self::assertSame(20.0, $rule->apply(20.0, ['condition' => 'fair']));
    }
}
