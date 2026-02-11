<?php

declare(strict_types=1);

namespace App\Tests\PricingBundle\Service;

use App\PricingBundle\Repository\CategoryPricingRepository;
use App\PricingBundle\Rule\ValuationRule;
use App\PricingBundle\Service\ValuationService;
use PHPUnit\Framework\TestCase;

final class ValuationServiceTest extends TestCase
{
    /**
     * @test
     */
    public function estimateAppliesOnlyRulesThatMatchContext(): void
    {
        /** @var CategoryPricingRepository|\PHPUnit\Framework\MockObject\MockObject $repository */
        $repository = $this->createMock(CategoryPricingRepository::class);
        $repository->expects(self::once())
            ->method('getBasePriceForCategory')
            ->with('dress')
            ->willReturn(20.0);

        /** @var ValuationRule|\PHPUnit\Framework\MockObject\MockObject $nonApplicableRule */
        $nonApplicableRule = $this->createMock(ValuationRule::class);
        $nonApplicableRule->expects(self::once())
            ->method('shouldApply')
            ->willReturn(false);
        $nonApplicableRule->expects(self::never())
            ->method('apply');

        /** @var ValuationRule|\PHPUnit\Framework\MockObject\MockObject $addFiveRule */
        $addFiveRule = $this->createMock(ValuationRule::class);
        $addFiveRule->expects(self::once())
            ->method('shouldApply')
            ->willReturn(true);
        $addFiveRule->expects(self::once())
            ->method('apply')
            ->with(20.0, self::anything())
            ->willReturn(25.0);

        /** @var ValuationRule|\PHPUnit\Framework\MockObject\MockObject $doubleRule */
        $doubleRule = $this->createMock(ValuationRule::class);
        $doubleRule->expects(self::once())
            ->method('shouldApply')
            ->willReturn(true);
        $doubleRule->expects(self::once())
            ->method('apply')
            ->with(25.0, self::anything())
            ->willReturn(50.0);

        // The order of rules matters, so we test that the service applies them in the correct sequence
        $service = new ValuationService($repository, [$nonApplicableRule, $addFiveRule, $doubleRule]);

        $result = $service->estimate('Zara', 'dress', 'good');

        self::assertSame(20.0, $result['basePrice']);
        self::assertSame(50.0, $result['estimatedPrice']);
     }

    /**
     * @test
     */
    public function estimateKeepsBasePriceWhenNoRuleApplies(): void
    {
        /** @var CategoryPricingRepository|\PHPUnit\Framework\MockObject\MockObject $repository */
        $repository = $this->createMock(CategoryPricingRepository::class);
        $repository->expects(self::once())
            ->method('getBasePriceForCategory')
            ->with('unknown')
            ->willReturn(12.5);

        /** @var ValuationRule|\PHPUnit\Framework\MockObject\MockObject $rule */
        $rule = $this->createMock(ValuationRule::class);
        $rule->expects(self::once())
            ->method('shouldApply')
            ->willReturn(false);
        $rule->expects(self::never())
            ->method('apply');

        $service = new ValuationService($repository, [$rule]);

        $result = $service->estimate('Any', 'unknown', 'fair');

        self::assertSame(12.5, $result['basePrice']);
        self::assertSame(12.5, $result['estimatedPrice']);
    }
}
