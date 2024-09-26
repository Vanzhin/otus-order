<?php

namespace App\Orders\Infrastructure\EventHandler;

use App\Orders\Domain\Event\OrderCreatedEvent;
use App\Orders\Domain\Message\ExternalMessageToForward;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Event\EventHandlerInterface;
use App\Shared\Application\Message\MessageBusInterface;
use App\Shared\Application\Service\BillingServiceInterface;
use App\Shared\Infrastructure\Api\Billing\VO\TransactionVO;
use Symfony\Component\Messenger\Bridge\Amqp\Transport\AmqpStamp;
use Symfony\Component\Messenger\Envelope;

readonly class OrderCreatedEventHandler implements EventHandlerInterface
{
    public function __construct(
        private BillingServiceInterface  $billingService,
        private OrderRepositoryInterface $orderRepository,
        private MessageBusInterface $messageBus,
    )
    {
    }

    public function __invoke(OrderCreatedEvent $event): string
    {
        $order = $this->orderRepository->findOneById($event->orderId);
        $transactionVo = new TransactionVO($order->getSum(), $order->getId(), 'order');
        $this->billingService->withdrawFromAccount($transactionVo, $order->getUserId());
        $message2 = new ExternalMessageToForward('order-created', $transactionVo->jsonSerialize());
        $envelope = new Envelope($message2, [new AmqpStamp("#")]);

        $this->messageBus->execute($envelope);

        return $order->getId();
    }
}
