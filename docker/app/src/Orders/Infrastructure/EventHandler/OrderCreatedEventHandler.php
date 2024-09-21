<?php

namespace App\Orders\Infrastructure\EventHandler;

use App\Orders\Domain\Event\OrderCreatedEvent;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Event\EventHandlerInterface;
use App\Shared\Application\Service\BillingServiceInterface;
use App\Shared\Infrastructure\Api\Billing\VO\TransactionVO;

readonly class OrderCreatedEventHandler implements EventHandlerInterface
{
    public function __construct(
        private BillingServiceInterface  $billingService,
        private OrderRepositoryInterface $orderRepository,
    )
    {
    }

    public function __invoke(OrderCreatedEvent $event): string
    {
        $order = $this->orderRepository->findOneById($event->orderId);
        $transactionVo = new TransactionVO($order->getSum(), $order->getId(), 'order');
        $this->billingService->withdrawFromAccount($transactionVo, $order->getUserId());

        return $order->getId();
    }
}
