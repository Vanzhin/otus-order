<?php

declare(strict_types=1);


namespace App\Orders\Application\UseCase\Command\CreateOrder;

use App\Orders\Domain\Service\OrderOrganizer;
use App\Shared\Application\Command\CommandHandlerInterface;

readonly class CreateOrderCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private OrderOrganizer $orderOrganizer,
    )
    {
    }

    public function __invoke(CreateOrderCommand $command): CreateOrderCommandResult
    {
        $order = $this->orderOrganizer->placeOrder($command->userId, $command->sum);

        return new CreateOrderCommandResult(
            $order->getId()
        );
    }
}
