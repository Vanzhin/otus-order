<?php

declare(strict_types=1);


namespace App\Orders\Application\UseCase\Command\CreateOrder;

use App\Orders\Domain\Factory\OrderFactory;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;

readonly class CreateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OrderFactory             $orderFactory,
        private OrderRepositoryInterface $orderRepository,
    )
    {
    }

    public function __invoke(CreateOrderCommand $command): CreateOrderCommandResult
    {
        $order = $this->orderFactory->create($command->userId, $command->sum);

        $this->orderRepository->add($order);

        return new CreateOrderCommandResult(
            $account->getId()
        );
    }
}
