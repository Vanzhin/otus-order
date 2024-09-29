<?php

namespace App\Orders\Infrastructure\EventHandler;

use App\Orders\Application\DTO\Order\OrderDTOTransformer;
use App\Orders\Domain\Aggregate\Order\OrderModification;
use App\Orders\Domain\Aggregate\Order\OrderStatus;
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
        private BillingServiceInterface              $billingService,
        private OrderRepositoryInterface             $orderRepository,
        private MessageBusInterface                  $messageBus,
        private OrderDTOTransformer                  $orderDTOTransformer,
    )
    {
    }

    public function __invoke(OrderCreatedEvent $event): string
    {
        $order = $this->orderRepository->findOneById($event->orderId);
        $transactionVo = new TransactionVO($order->getSum(), $order->getId(), 'order');
        $response = $this->billingService->withdrawFromAccount($transactionVo, $order->getUserId());
        // меняю статус в зависимости от успеха оплаты
        $order->addModification(
            new OrderModification(
                $order,
                $response->isSuccess() ? OrderStatus::PAID : OrderStatus::PAYMENT_AWAIT));
        $this->orderRepository->add($order);

        $orderDto = $this->orderDTOTransformer->fromAccountEntity($order);
        $message = new ExternalMessageToForward($order->getLastModification()->getStatus()->value, $orderDto->jsonSerialize());
        $envelope = new Envelope($message, [new AmqpStamp("#")]);

        $this->messageBus->execute($envelope);

        return $order->getId();
    }
}
