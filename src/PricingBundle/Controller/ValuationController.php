<?php

declare(strict_types=1);

namespace App\PricingBundle\Controller;

use App\PricingBundle\Service\ValuationService;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

final class ValuationController
{
    private const ALLOWED_CONDITIONS = ['new', 'good', 'fair'];

    /** @var ValuationService */
    private $valuationService;

    public function __construct(ValuationService $valuationService)
    {
        $this->valuationService = $valuationService;
    }

    public function __invoke(Request $request): JsonResponse
    {
        $payload = json_decode($request->getContent(), true);

        if (!\is_array($payload)) {
            return new JsonResponse([
                'error' => 'Invalid JSON payload.',
            ], 400);
        }

        $brand = isset($payload['brand']) ? trim((string) $payload['brand']) : '';
        $category = isset($payload['category']) ? trim((string) $payload['category']) : '';
        $condition = isset($payload['condition']) ? strtolower(trim((string) $payload['condition'])) : '';

        $validationErrors = [];
        if ($brand === '') {
            $validationErrors['brand'] = 'brand is required.';
        }

        if ($category === '') {
            $validationErrors['category'] = 'category is required.';
        }

        if (!\in_array($condition, self::ALLOWED_CONDITIONS, true)) {
            $validationErrors['condition'] = sprintf(
                'condition must be one of: %s',
                implode(', ', self::ALLOWED_CONDITIONS)
            );
        }

        if ($validationErrors !== []) {
            return new JsonResponse([
                'error' => 'Validation failed.',
                'details' => $validationErrors,
            ], 422);
        }

        $valuation = $this->valuationService->estimate($brand, $category, $condition);

        return new JsonResponse($valuation, 200);
    }
}
