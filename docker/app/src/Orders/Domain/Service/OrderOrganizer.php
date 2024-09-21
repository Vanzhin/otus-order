<?php
declare(strict_types=1);


namespace App\Orders\Domain\Service;

use App\Orders\Domain\Aggregate\Order\Order;
use App\Shared\Application\Service\BillingServiceInterface;
use App\Shared\Domain\Service\AssertService;


readonly class OrderOrganizer
{
    public function __construct(
        private OrderMaker              $maker,
        private BillingServiceInterface $billingService,
    )
    {
    }

    public function placeOrder(string $userId, float $sum): Order
    {
        $response = $this->billingService->getAccountBalance($userId);
        AssertService::true($response->isSuccess(), $response->getMessage());
        AssertService::lessThanEq($response->getData(), $sum, 'User has not enough money in the account.');

        return $this->maker->make($userId, $sum);
    }

}